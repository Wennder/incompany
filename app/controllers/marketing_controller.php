<?php

class marketingController extends AppController {
    
    public $uses = array(
        "marketing_banners",
        "marketing_templateemails",
        "sys_modulos"
    );
    
    public function index($op){
        $this->set("op",$op);
        switch ($op) {
            case "dashboard":
                
                break;
        }
    }
    
    public function templateEmails($op=null,$id=null){
        $this->set("op",$op);
        switch ($op) {
            case "cadastrar":
                if(!empty($this->data)){
                    $this->data["templateEmail_id"] = $id;
                    if($this->marketing_templateemails->save($this->data)){
                        die("Salvo com Sucesso");
                    }else{
                        die("Ocorreu um erro durante sua requisição.");
                    }
                }
                $this->set("dadosForm",$this->marketing_templateemails->firstById($id));
                break;

            default:
                case "grid":
                    $condicao = array(
                        "order"=>"id_modulo, titulo"
                    );
                    $this->set("dadosGrid",$this->marketing_templateemails->all($condicao));
                break;
        }
        $condicaoModulos = array(
            "conditions"=>array(
                "ativo"=>"1",
                "menuPrincipal"=>"1"
            ),
            "displayField"=>"nome",
            "order"=>"nome"
        );
        $this->set("optModulos",$this->sys_modulos->toList($condicaoModulos));
    }
    
    public function banners($op="grid", $id=null) {
        $this->set("tiposBanner", $this->tiposBanner);
        $this->set("op", $op);
        switch ($op) {
            case "novo":
                if (!empty($this->data)) {
                    $this->data['id'] = $id;
                    if ($this->marketing_banners->save($this->data)) {
                        $this->setAlert("Salvo com sucesso");
                        $this->redirect("/marketing/banners/grid");
                    } else {
                        $this->setAlert("Ocorreu algum erro, tente novamente.");
                        $this->redirect("/marketing/banners/grid");
                    }
                }
                $this->set("dadosFormulario", $this->marketing_banners->firstById($id));
                break;
            case "upload":
                $this->layout=false;
                if (!empty($_FILES)){
                    $this->UploadComponent->path = "/images/marketing/";
                    $file = $this->UploadComponent->files["anexo"]; //o erro praticamente estava aqui
                    $filename = $this->AuthComponent->createPassword() . "." . $this->UploadComponent->ext($file);
                    $upload = $this->UploadComponent->upload($file, null, $filename);
                    //pr($this->UploadComponent->errors);
                  if($upload){
                    echo "<script>
                      window.opener.document.getElementById('cke_105_textInput').value='{$this->UploadComponent->path}$filename';
                      self.close()
                      </script>";
                    
                  }
                }
                break;
            case "grid":
                $this->set("dadosGrid", $this->marketing_banners->all());
                break;
            case "deletar":
                $this->marketing_banners->delete($id);
                $this->redirect("/marketing/banners/grid");
                break;
        }
    }

}

?>
