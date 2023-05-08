<?php
defined('BASEPATH') OR exit('No direct script acess allowed');

#[\AllowDynamicProperties]

class Project extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->model('Project_model', 'project'); 
    }

    /* view page */
    public function index()
    {
        $data['title'] = "Codeigniter Project Manager";
        $this->load->view('project', $data); /* aqui altera o view */
    }

    /* puxa os dados */

    public function show_all()
    {
        $project = $this->project->get_all();
        header('Content-Type: application/json');
        echo json_encode($project);
    }
    
    /* pegar especifico */
    public function show($id)
    {
        $project = $this->project->get($id);
        header('Content-Type: application/json');
        echo json_encode($project);
    }

    public function store()
    {
        $this->form_validation->set_rules('nome', 'Nome', 'required|min_length[5]');
        $this->form_validation->set_rules('descricao', 'Descrição', 'required');
        $this->form_validation->set_rules('cpf', 'CPF', 'required');
        $this->form_validation->set_rules('rg', 'RG', 'required');
        $this->form_validation->set_rules('sexo', 'Sexo', 'required');
        $this->form_validation->set_rules('cep', 'CEP', 'required');
        $this->form_validation->set_rules('cidade', 'Cidade', 'required');
        $this->form_validation->set_rules('bairro', 'Bairro', 'required');
        $this->form_validation->set_rules('rua', 'Rua', 'required');
        $this->form_validation->set_rules('numero', 'Numero', 'required');


        if (!$this->form_validation->run())
        {
            http_response_code(412);
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'error',
                'errors' => validation_errors()
            ]);
        }
        else {
            $this->project->store();
            header('Content-Type: application/json');
            echo json_encode(['status' => "success"]);
        }
    }

    public function edit($id)
    {
        $project = $this->project->get($id);
        header('Content-Type: application/json');
        echo json_encode($project);
    }

    public function update($id)
    {
        $this->form_validation->set_rules('nome', 'Nome', 'required');
        $this->form_validation->set_rules('descricao', 'Descrição', 'required');
        $this->form_validation->set_rules('cpf', 'CPF', 'required');
        $this->form_validation->set_rules('rg', 'RG', 'required');
        $this->form_validation->set_rules('sexo', 'Sexo', 'required');
        $this->form_validation->set_rules('cep', 'CEP', 'required');
        $this->form_validation->set_rules('cidade', 'Cidade', 'required');
        $this->form_validation->set_rules('bairro', 'Bairro', 'required');
        $this->form_validation->set_rules('rua', 'Rua', 'required');
        $this->form_validation->set_rules('numero', 'Numero', 'required');
        if (!$this->form_validation->run())
        {
            http_response_code(412);
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'error',
                'errors' => validation_errors()
            ]);
        }
        else {
            $this->project->update($id);
            header('Content-Type: application/json');
            echo json_encode(['status' => "success"]);
        }
    }
    public function delete($id)
    {
        $item = $this->project->delete($id);
        header('Content-Type: application/json');
        echo json_encode(['status' => "successs"]);
    }
}