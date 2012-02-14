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
            array('formulars' => Formular::find_all_by_status('rechnung')), true);
        $this->content_view = 'control/incoming/index';
    }

    public function provision()
    {
        $this->view_data['page_title'] = 'Provision Payments';

        $formulars = array();
        foreach (Formular::find_all_by_status('rechnung') as $formular)
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

    public function search_formulars($type = 'incoming')
    {

        $search_field = $this->input->post('search_field');
        $search_string = $this->input->post('search_string');

        $von = inputdate_to_mysqldate($this->input->post('von'));
        $bis = inputdate_to_mysqldate($this->input->post('bis'));

        $formulars = array();

        if ($search_string)
            $formulars = Formular::find('all', array('conditions' => array('status = "rechnung" AND ' . $search_field . ' like "%' . $search_string . '%"')));
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
                $formulars = Formular::find('all', array('conditions' => array('status = "rechnung" AND ' . $search_field . ' >= ? AND ' . $search_field . ' <= ?', $von, $bis)));
            }
        }
        else
            $formulars = Formular::find_all_by_status('rechnung');

        if($type == 'provision')
        {
            $result = array();
            foreach($formulars as $formular)
                if($formular->kunde && $formular->kunde->type == "agenturen")
                    $result[] = $formular;
        }
        else
            $result = $formulars;


        echo $this->load->view('control/' . $type . '/invoice_list.php', array('formulars' => $result), true);
        exit();
    }

    public function add_payment($type = 'incoming', $formular_id = 0)
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
                'amount' => $this->input->post('amount'),
                'added_time' => time_to_mysqldatetime(time()),
                'added_by' => $this->user->id,
            ));

            $formular->is_freigabe = $formular->paid_amount >= $formular->brutto ? true : false;
            $formular->save();
        }
        else if ($type == "provision")
            ProvisionPayment::create(array(
                'formular_id' => $formular_id,
                'payment_date' => inputdate_to_mysqldate($this->input->post('date')),
                'remark' => $this->input->post('remark'),
                'amount' => $this->input->post('amount'),
                'added_time' => time_to_mysqldatetime(time()),
                'added_by' => $this->user->id,
            ));

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
}
