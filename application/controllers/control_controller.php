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
        $this->view_data['page_title'] = 'Kontrolle';
        $this->view_data['invoice_list'] = $this->load->view('control/invoice_list.php',
            array('formulars' => Formular::find_all_by_status('rechnung')), true);
    }

    public function payments($id)
    {
        $formular = Formular::find_by_id($id);

        $html = $this->load->view("control/payments.php", array(
            'formular' => $formular,
            'payments_list' => $this->load->view('control/payments_list.php', array('formular' => $formular), true),
        ), TRUE);

        echo $html;
        exit();
    }

    public function add_payment($formular_id)
    {

        $formular = Formular::find_by_id($formular_id);

        FormularPayment::create(array(
            'formular_id' => $formular_id,
            'payment_date' => inputdate_to_mysqldate($this->input->post('date')),
            'remark' => $this->input->post('remark'),
            'amount' => $this->input->post('amount'),
            'added_time' => time_to_mysqldatetime(time()),
            'added_by' => $this->user->id,
        ));

        echo $this->load->view('control/payments_list.php', array('formular' => $formular), true);

        exit();
    }

    public function delete_payment($formular_id, $payment_id)
    {
        $payment = FormularPayment::find_by_id($payment_id);
        $payment->delete();

        echo $this->load->view('control/payments_list.php', array('formular' => Formular::find_by_id($formular_id)), true);

        exit();
    }
}
