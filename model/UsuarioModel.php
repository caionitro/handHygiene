<?php
    class UsuarioModel extends Connect
    {
      private $id;
      private $nome;
      private $email;
      private $login;
      private $senha;
      private $dataCadastro;
      private $users = [];

      public function __construct(){}

      public function saveUser(){
          if(!$this->id){
            $db = parent::getInstanceMysql();
            $query = $db->prepare('insert into usuario (nome, email, login, senha) values (:nome, :email, :login, :senha)');
            $query->bindValue(":nome",$this->getNome(),PDO::PARAM_STR);
            $query->bindValue(":email",$this->getEmail(),PDO::PARAM_STR);
            $query->bindValue(":login",$this->getLogin(),PDO::PARAM_STR);
            $query->bindValue(":senha",$this->getSenha(),PDO::PARAM_STR);
            $query->execute();

          }else{
            $db = parent::getInstanceMysql();
            $query = $db->prepare('update usuario 
                                  set nome=:nome, email=:email, login=:login, senha=:senha 
                                  where idUsuario=:idUsuario');
            $query->bindValue(":idUsuario",$this->getId(),PDO::PARAM_INT);
            $query->bindValue(":nome",$this->getNome(),PDO::PARAM_STR);
            $query->bindValue(":email",$this->getEmail(),PDO::PARAM_STR);
            $query->bindValue(":login",$this->getLogin(),PDO::PARAM_STR);
            $query->bindValue(":senha",$this->getSenha(),PDO::PARAM_STR);
            $query->execute();

          }
        return true;
      }

      public function userLogin(){
        $db = parent::getInstanceMysql();
        $query = $db->prepare('select idUsuario, nome, email, login, senha, dataCadastro, updated, ativo
                                  from usuario
                                  where login=:login and senha=:senha');
        $query->bindValue(":login",$this->getLogin(),PDO::PARAM_STR);
        $query->bindValue(":senha",$this->getSenha(),PDO::PARAM_STR);
        $query->execute();

        $this->users['usuario'] = $query->fetch(PDO::FETCH_ASSOC);

        if ($this->users['usuario']) {
          session_start();
          $this->users['login'] = 'accepted';
          $_SESSION['user'] = array(
                                    'idUsuario' => $this->users['usuario']['idUsuario'],
                                    'nome' => $this->users['usuario']['nome'],
                                    'email' => $this->users['usuario']['email'],
                                    'login' => $this->users['usuario']['login']
                                    );
        }else{
          unset($_SESSION, $this->users);
          $this->users['login'] = 'denied';
        }

        return $this->users;
      }

      public function deleteUser($idUsuario){

        $db = parent::getInstanceMysql();
        $query = $db->prepare('delete from usuario where idUsuario=:idUsuario');
        $query->bindValue(":idUsuario",$idUsuario,PDO::PARAM_INT);
        $query->execute();

        return true;
      }

      public function getAllUsers(){

          $db = parent::getInstanceMysql();
          $query = $db->prepare('select idUsuario, nome, email, login, senha, dataCadastro, ativo 
                                  from usuario');
          $query->execute();
          $this->users = $query->fetchAll();

          return $this->users;
      }

      public function getUserById($idUsuario){
        
          $db = parent::getInstanceMysql();
          $query = $db->prepare('SELECT idUsuario, nome, email, login, dataCadastro, ativo 
                                  FROM usuario
                                  WHERE idUsuario = :idUsuario');
          $query->bindValue(":idUsuario",$idUsuario,PDO::PARAM_INT);
          $query->execute();
          $this->users = $query->fetch();

          return $this->users;
      }



      
      /**
       * Gets the value of id.
       *
       * @return mixed
       */
      public function getId()
      {
          return $this->id;
      }

      /**
       * Sets the value of id.
       *
       * @param mixed $id the id
       *
       * @return self
       */
      public function setId($id)
      {
          $this->id = $id;
      }

      /**
       * Gets the value of nome.
       *
       * @return mixed
       */
      public function getNome()
      {
          return $this->nome;
      }

      /**
       * Sets the value of nome.
       *
       * @param mixed $nome the nome
       *
       * @return self
       */
      public function setNome($nome)
      {
          $this->nome = $nome;
      }

      /**
       * Gets the value of email.
       *
       * @return mixed
       */
      public function getEmail()
      {
          return $this->email;
      }

      /**
       * Sets the value of email.
       *
       * @param mixed $email the email
       *
       * @return self
       */
      public function setEmail($email)
      {
          $this->email = $email;
      }

      /**
       * Gets the value of login.
       *
       * @return mixed
       */
      public function getLogin()
      {
          return $this->login;
      }

      /**
       * Sets the value of login.
       *
       * @param mixed $login the login
       *
       * @return self
       */
      public function setLogin($login)
      {
          $this->login = $login;
      }

      /**
       * Gets the value of senha.
       *
       * @return mixed
       */
      public function getSenha()
      {
          return $this->senha;
      }

      /**
       * Sets the value of senha.
       *
       * @param mixed $senha the senha
       *
       * @return self
       */
      public function setSenha($senha)
      {
          $this->senha = md5($senha);
      }
}