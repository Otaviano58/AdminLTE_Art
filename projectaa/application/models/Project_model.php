<?php
 
 
class Project_model extends CI_Model{
 
    public function __construct()
    {
        $this->load->database();
        $this->load->helper('url');
    }
 
    /*
        Get all the records from the database
    */
    public function get_all()
    {
        $projects = $this->db->get("projects")->result();
        return $projects;
    }
 
    /*
        Store the record in the database
    */
    public function store()
    {    
        $data = [
            'nome' => $this->input->post('nome'),
            'descricao' => $this->input->post('descricao'),
            'cpf' => $this->input->post('cpf'),
            'rg' => $this->input->post('rg'),
            'sexo' => $this->input->post('sexo'),
            'cep' => $this->input->post('cep'),
            'cidade' => $this->input->post('cidade'),
            'bairro' => $this->input->post('bairro'),
            'rua' => $this->input->post('rua'),
            'numero' => $this->input->post('numero'),
            'estado' => $this->input->post('estado')

        ];
 
        $result = $this->db->insert('projects', $data);
        return $result;
    }
 
    /*
        Get an specific record from the database
    */
    public function get($id)
    {
        $project = $this->db->get_where('projects', ['id' => $id ])->row();
        return $project;
    }
 
 
    /*
        Update or Modify a record in the database
    */
    public function update($id) 
    {
        $data = [
            'nome' => $this->input->post('nome'),
            'descricao' => $this->input->post('descricao'),
            'cpf' => $this->input->post('cpf'),
            'rg' => $this->input->post('rg'),
            'sexo' => $this->input->post('sexo'),
            'cep' => $this->input->post('cep'),
            'cidade' => $this->input->post('cidade'),
            'bairro' => $this->input->post('bairro'),
            'rua' => $this->input->post('rua'),
            'numero' => $this->input->post('numero'),
            'estado' => $this->input->post('estado')
        ];
 
        $result = $this->db->where('id',$id)->update('projects',$data);
        return $result;
                 
    }
 
    /*
        Destroy or Remove a record in the database
    */
    public function delete($id)
    {
        $result = $this->db->delete('projects', array('id' => $id));
        return $result;
    }
     
}
?>