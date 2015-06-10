<?php
    class LoginModel extends Connect
    {
        private $login;
        private $senha;
        private $users = [];

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

            return $this;
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

            return $this;
        }
}