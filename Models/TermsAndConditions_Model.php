<?php
/**
 * Created by PhpStorm.
 * User: suleymantopaloglu
 * Date: 2019-05-15
 * Time: 14:13
 */

class TermsAndConditions_Model extends Model
{
        function __construct() {
                parent::__construct();
        }

        function getTACContent(){
                $sql = "SELECT * FROM tacs WHERE tac_group_id=" . $this->pars->tac_id . " AND ( tac_from_at IS NULL OR tac_from_at < NOW() ) AND ( tac_until_to IS NULL OR tac_until_to > NOW() )";
                $this->db = new Database();
                $this->db->setQuery($sql);
                return $this->db->fetch();
        }

}



