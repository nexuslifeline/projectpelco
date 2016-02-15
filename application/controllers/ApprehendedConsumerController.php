<?php

class ApprehendedConsumerController extends CI_Controller {

    function __construct(){ // gets called every time the controller is loaded (example: $unit=new Unit_controller()) or when called in url
        // Call the Model constructor
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('ApprehendedConsumerModel');
    }

    function index(){		// the default function that is called if no function is given in the uri
        $this->load->view('record_back_billing_account');
    }

    function ActionGetUnitItemList(){
        echo json_encode(
            $this->ApprehendedConsumerModel->ReturnUnitItemList()
        );
    }

    function ActionGetApprehendedConsumerList(){
        echo json_encode(
            $this->ApprehendedConsumerModel->ReturnApprehendedConsumerList()
        );
    }


    function ActionSaveApprehendedConsumerInfo(){
        if($this->ApprehendedConsumerModel->CreateApprehendedAccount()){

            echo json_encode(
                array(
                    'stat'=>'success',
                    'msg'=>'Apprehended Consumer Account successfully created.',
                    'row'=>$this->ApprehendedConsumerModel->ReturnLastAffectedRowDetails()
                )
            );

        }
    }

    function ActionUpdateApprehendedAccountInfo(){
        if($this->ApprehendedConsumerModel->UpdateApprehendAccount()){
            echo json_encode(
                array(
                    'stat'=>'success',
                    'msg'=>'Apprehended Consumer Account successfully updated.',
                    'row'=>$this->ApprehendedConsumerModel->ReturnLastAffectedRowDetails()

                )
            );

        }
    }

    function ActionGetAccountCartItems(){
        $id=$this->input->get('id',TRUE);
        echo json_encode(
            $this->ApprehendedConsumerModel->ReturnAccountCartItems($id)
        );
    }


    function ActionGetPaymentScheduleItem(){
        $id=$this->input->get('id',TRUE);
        echo json_encode(
            $this->ApprehendedConsumerModel->ReturnPaymentScheduleItems($id)
        );
    }

    function ActionGetCurrentAccountSchedule(){
        $id=$this->input->get('id',TRUE);
        echo json_encode(
            $this->ApprehendedConsumerModel->ShowCurrentAccountSchedule($id)
        );
    }


    function ActionGetConsumerLedger(){
        $id=$this->input->get('id');
        echo json_encode(
            $this->ApprehendedConsumerModel->GetConsumerLedger($id)
        );
    }


    function ActionPreviewConsumerLedger(){
        //load mPDF library
        $id=$this->input->get('accid'); //bill account id
        $dl=0;
        $pdfFilePath = "LEDGER.pdf"; //generate filename base on id

        $this->load->library('m_pdf');
        $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class

        $data['ledger']=$this->ApprehendedConsumerModel->GetConsumerLedger($id); //return array of consumer ledger
        $data['consumer']=$this->ApprehendedConsumerModel->ReturnApprehendedConsumerList($id); //return array of consumer info

        $content=$this->load->view('reports/rpt_consumer_ledger',$data,TRUE); //load our template
        $pdf->setFooter('{PAGENO}');
        $pdf->WriteHTML($content);

        if($dl){
            //download it.
            $pdf->Output($pdfFilePath,"D");
        }else{
            //just output it on browser
            $pdf->Output();
        }
    }


    function ActionPreviewDelinquent(){
        //load mPDF library



        $this->load->library('m_pdf');
        $pdf = $this->m_pdf->load('A4-L'); //pass the instance of the mpdf class
        $data['delinquent']=$this->ApprehendedConsumerModel->GetDelinquentList();

        $content=$this->load->view('reports/rpt_delinquent',$data,TRUE); //load our template
        $pdf->setFooter('{PAGENO}');
        $pdf->WriteHTML($content);


        //just output it on browser
        $pdf->Output();

    }


    function ActionGetDelinquentList(){
        echo json_encode(
            $this->ApprehendedConsumerModel->GetDelinquentList()
        );
    }


    function ActionPreviewSchedule(){
        $id=$this->input->get('accid');

        $data['list']=$this->ApprehendedConsumerModel-> ReturnPaymentScheduleItems($id);
        $data['consumer']=$this->ApprehendedConsumerModel->ReturnApprehendedConsumerList($id); //return array of consumer info

        $this->load->library('m_pdf');
        $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class

        $content=$this->load->view('reports/rpt_schedule',$data,TRUE); //load our template
        $pdf->setFooter('{PAGENO}');
        $pdf->WriteHTML($content);


        //just output it on browser
        $pdf->Output();
    }




}

?>