<?php

class Control_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->user)
            redirect('login');

        $this->view_data['JS_files'] = array("js/control.js");
    }

    public function index()
    {
        $this->view_data['page_title'] = 'Control & Finanzen';
    }

    public function incoming()
    {
        $this->view_data['page_title'] = 'Incoming Payments';
        $this->view_data['invoice_list'] = $this->load->view('control/incoming/invoice_list.php',
            array('formulars' => $this->search_formulars('incoming', false)), true);
        $this->content_view = 'control/incoming/index';
    }

    public function invoice($formular_id = 0)
    {
        $formular = Formular::find_by_id($formular_id);
        if ($formular) {
            $this->view_data['invoices'] = array(
                'hotel' => $this->get_invoices($formular_id, 'hotel'),
                'transfer' => $this->get_invoices($formular_id, 'transfer'),
                'rundreise' => $this->get_invoices($formular_id, 'rundreise'),
                'flight' => $this->get_invoices($formular_id, 'flight'),
                'other' => $this->get_invoices($formular_id, 'other'));
            $this->view_data['formular'] = $formular;

            $this->view_data['stats'] = $this->load->view('control/invoice/invoice_stats.php', array('stats' => $formular->invoice_stats), true);

            $this->content_view = 'control/invoice/invoices';
        }
        else {
            $this->view_data['page_title'] = 'Invoise Payments';

            $this->view_data['invoice_list'] = $this->load->view('control/invoice/rechnung_list.php',
                array('formulars' => Formular::find_all_by_status('rechnung')), true);

            $this->content_view = 'control/invoice/index';
        }
    }

    public function get_invoices($formular_id, $type)
    {
        $invoices = $data = $payments = array();
        $incoming = null;
        if ($type == "other") {
            $invoices = Invoice::find('all', array('conditions' => array('formular_id = ? AND type = "other"', $formular_id)));

            $payments = array();
            foreach ($invoices as $ind => $invoice)
                $payments[$ind] = $this->load->view('control/invoice/payments_list.php', array('invoice' => $invoice), true);

            $data[] = array('invoices' => $invoices, 'payments' => $payments);
        }
        else {

            $formular = Formular::find_by_id($formular_id);
            foreach ($formular->incomings as $incoming)
            {
                switch ($type) {
                    case 'hotel':
                        $invoices = Invoice::find('all', array('conditions' => array('formular_id = ? AND incoming_id = ? AND type = "hotel"', $formular_id, $incoming->id)));
                        break;
                    case 'rundreise':
                        $invoices = Invoice::find('all', array('conditions' => array('formular_id = ? AND incoming_id = ? AND type = "rundreise"', $formular_id, $incoming->id)));
                        break;
                    case 'flight':
                        $invoices = Invoice::find('all', array('conditions' => array('formular_id = ? AND incoming_id = ? AND (type = "flight_other" OR type = "flight_line" OR type = "flight_charter" OR type = "flight_lowcost")', $formular_id, $incoming->id)));
                        break;

                    case 'transfer':
                        $invoices = Invoice::find('all', array('conditions' => array('formular_id = ? AND incoming_id = ? AND type = "transfer"', $formular_id, $incoming->id)));
                        break;
                }


                $payments = array();
                foreach ($invoices as $ind => $invoice)
                    $payments[$ind] = $this->load->view('control/invoice/payments_list.php', array('invoice' => $invoice), true);
                $data[] = array('incoming' => $incoming, 'invoices' => $invoices, 'payments' => $payments);

            }
        }


        return $this->load->view('control/invoice/invoice_list.php', array('type' => $type, 'incoming_invoices' => $data), true);
    }

    public function provision()
    {
        $this->view_data['page_title'] = 'Provision Payments';

        $formulars = array();
        foreach ($this->search_formulars('provision', false) as $formular)
            if ($formular->kunde && $formular->kunde->type == "agenturen")
                $formulars[] = $formular;

        $this->view_data['invoice_list'] = $this->load->view('control/provision/invoice_list.php',
            array('formulars' => $formulars), true);
        $this->content_view = 'control/provision/index';

    }

    public function payments($type = 'incoming', $id)
    {
        $formular = Formular::find_by_id($id);
        if (!$formular)
            show_404();

        $html = $this->load->view("control/" . $type . "/payments.php", array(
            'formular' => $formular,
            'payments_list' => $this->load->view("control/" . $type . "/payments_list.php", array('formular' => $formular), true),
        ), TRUE);

        echo $html;
        exit();
    }

    public function search_formulars($type = 'incoming', $output = true)
    {

        $search_field = $this->input->post('search_field');
        $search_string = $this->input->post('search_string');

        $von = inputdate_to_mysqldate($this->input->post('von'));
        $bis = inputdate_to_mysqldate($this->input->post('bis'));

        $kunde = $this->input->post('ag_num') ? Kunde::find_by_k_num($this->input->post('ag_num')) : 0;
        $kunde_query = $kunde ? ' AND kunde_id="'.$kunde->id.'"' : '';
        $formulars = array();

        if ($search_string)
            $formulars = Formular::find('all', array('conditions' =>
            array('status = "rechnung"'.$kunde_query.' AND ' . $search_field . ' like "%' . $search_string . '%"')));
        else if ($von && $bis) {
            $search_map = array(
                'buchung' => 'created_date',
                'rechnung' => 'rechnung_date',
                'abreise' => 'departure_date',
                'anzahlung' => 'prepayment_date',
                'restzahlung' => 'finalpayment_date',
                'provision' => 'provision_date',
                'versand' => 'versanded_date'
            );

            if (isset($search_map[$search_field])) {
                $search_field = $search_map[$search_field];
                $formulars = Formular::find('all', array('conditions' =>
                array('status = "rechnung"'.$kunde_query.' AND ' . $search_field . ' >= ? AND ' . $search_field . ' <= ?', $von, $bis)));
            }
        }
        else
            $formulars = Formular::all(array(
                    'conditions' => array('status = "rechnung"'.$kunde_query),
                    'order' => 'r_num')
            );

        if ($type == 'provision') {
            $result = array();
            foreach ($formulars as $formular)
                if ($formular->kunde && $formular->kunde->type == "agenturen")
                    $result[] = $formular;
        }
        else
            $result = $formulars;

        if ($output) {
            echo $this->load->view('control/' . $type . '/invoice_list.php', array('formulars' => $result), true);
            exit();
        }
        else
            return $result;
    }

    public function add_payment($type = 'incoming', $formular_id = 0, $invoice_id = 0)
    {

        $formular = Formular::find_by_id($formular_id);
        if (!$formular)
            show_404();

        if ($type == 'incoming') {
            IncomingPayment::create(array(
                'formular_id' => $formular_id,
                'type' => $this->input->post('type'),
                'payment_date' => inputdate_to_mysqldate($this->input->post('date')),
                'remark' => $this->input->post('remark'),
                'amount' => str_replace(',', '.', $this->input->post('amount')),
                'added_time' => time_to_mysqldatetime(time()),
                'added_by' => $this->user->id,
            ));

            $formular->is_freigabe = $formular->paid_amount >= ($formular->brutto - 0.2) ? true : false;
            $formular->save();
        }
        else if ($type == "provision")
            ProvisionPayment::create(array(
                'formular_id' => $formular_id,
                'payment_date' => inputdate_to_mysqldate($this->input->post('date')),
                'remark' => $this->input->post('remark'),
                'amount' => str_replace(',', '.', $this->input->post('amount')),
                'added_time' => time_to_mysqldatetime(time()),
                'added_by' => $this->user->id,
            ));
        else if ($type == "invoice") {
            $invoice = Invoice::find_by_id($this->input->post('invoice_id'));
            InvoicePayment::create(array(
                'invoice_id' => $this->input->post('invoice_id'),
                'payment_amount' => str_replace(',', '.', $this->input->post('amount')),
                'payment_date' => inputdate_to_mysqldate($this->input->post('date')),
                'payment_remark' => $this->input->post('remark'),
                'payment_type' => $this->input->post('type'),
                'added_by' => $this->user->id,
                'added_date' => time_to_mysqldatetime(time())
            ));

            $payments = $this->load->view('control/invoice/payments_list.php',
                array('invoice' => $invoice, 'type' => $this->input->post('invoice_type')), true);

            echo json_encode(array('payments' => $payments, 'invoice_status' => $invoice->status,
                'stats' => $this->load->view('control/invoice/invoice_stats.php', array('stats' => $formular->invoice_stats), true)));

            exit();
        }

        echo $this->load->view('control/' . $type . '/payments_list.php', array('formular' => $formular), true);

        exit();
    }

    public function delete_payment($type = 'incoming', $formular_id, $payment_id)
    {
        $formular = Formular::find_by_id($formular_id);

        if (!$formular)
            show_404();

        if ($type == "incoming")
            $payment = IncomingPayment::find_by_id($payment_id);
        elseif ($type == "provision")
            $payment = ProvisionPayment::find_by_id($payment_id);
        elseif ($type == "invoice")
        {
            $payment = InvoicePayment::find_by_id($payment_id);
            $invoice = Invoice::find_by_id($this->input->post('invoice_id'));
            $payment->delete();


            $payments = $this->load->view('control/invoice/payments_list.php',
                array('invoice' => $invoice, 'type' => $this->input->post('invoice_type')), true);
            echo json_encode(array('payments' => $payments, 'invoice_status' => $invoice->status,
                'stats' => $this->load->view('control/invoice/invoice_stats.php', array('stats' => $formular->invoice_stats), true)));


            exit();
        }
        $payment->delete();

        $formular->is_freigabe = $formular->paid_amount >= $formular->brutto ? true : false;
        $formular->save();

        echo $this->load->view('control/' . $type . '/payments_list.php', array('formular' => Formular::find_by_id($formular_id)), true);

        exit();
    }

    public function versand($formular_id = 0)
    {
        $formular = Formular::find_by_id($formular_id);
        if (!$formular)
            show_404();

        $val = $this->input->post('value');
        if ($val) {
            $formular->versanded_date = time_to_mysqldatetime(time());
            $formular->versanded_by = $this->user->id;
        }

        $formular->is_versand = $val;
        $formular->save();

        exit();
    }

    public function add_invoice($formular_id = 0, $incoming_id = 0)
    {
        $formular = Formular::find_by_id($formular_id);

        if (!$formular) {
            show_404();
            exit();
        }

        Invoice::create(array(
            'formular_id' => $formular_id,
            'incoming_id' => $incoming_id,
            'number' => $this->input->post('number'),
            'type' => $this->input->post('type'),
            'amount' => $this->input->post('amount'),
            'date' => inputdate_to_mysqldate($this->input->post('date')),
            'remark' => $this->input->post('remark'),
            'created_by' => $this->user->id,
            'created_date' => time_to_mysqldatetime(time())
        ));

        echo json_encode(array('invoices' => $this->get_invoices($formular_id, $this->input->post('type')),
            'stats' => $this->load->view('control/invoice/invoice_stats.php', array('stats' => $formular->invoice_stats), true)));

        exit();
    }

    public function delete_invoice($invoice_id)
    {
        $invoice = Invoice::find_by_id($invoice_id);
        $type = $invoice->type;

        $formular = Formular::find_by_id($invoice->formular_id);

        $invoice->delete();


        if (substr($type, 0, strlen('flight')) == "flight")
            $type = "flight";

        echo json_encode(array('invoices' => $this->get_invoices($invoice->formular_id, $type),
            'stats' => $this->load->view('control/invoice/invoice_stats.php', array('stats' => $formular->invoice_stats), true)));
        exit();
    }

    public function toggle_netto($formular_id)
    {
        $formular = Formular::find_by_id($formular_id);

        if (!$formular) {
            show_404();
            exit();
        }

        $formular->payment_netto = $formular->payment_netto ? 0 : 1;
        $formular->save();

        ProvisionPayment::table()->delete(array(
            'formular_id' => $formular_id,
            'added_by' => 0
        ));

        IncomingPayment::table()->delete(array(
            'formular_id' => $formular_id,
            'added_by' => 0
        ));

        if ($formular->payment_netto) {
            ProvisionPayment::create(array(
                'formular_id' => $formular_id,
                'payment_date' => time_to_mysqldate(time()),
                'amount' => $formular->provision_amount,
                'remark' => 'RB-einbehalten',
                'added_time' => time_to_mysqldatetime(time()),
                'added_by' => 0
            ));
            IncomingPayment::create(array(
                'formular_id' => $formular_id,
                'payment_date' => time_to_mysqldate(time()),
                'amount' => $formular->provision_amount,
                'remark' => 'RB-einbehalten',
                'added_time' => time_to_mysqldatetime(time()),
                'added_by' => 0
            ));
        }


        echo $this->load->view('control/incoming/payments_list.php', array('formular' => $formular), true);

        exit();
    }
}
