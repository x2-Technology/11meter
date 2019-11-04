<?php
/**
 * Created by PhpStorm.
 * User: suleymantopaloglu
 * Date: 2019-10-30
 * Time: 10:05
 *
 * How to Use *
 */
ob_start();
error_reporting(E_ALL);
spl_autoload_register(function ($className){
        include $className . '.php';
});


/*
$repository = new Repository(Repository::$REPO_SESSION);
echo $repository->getInstance()->getInfo() . "<br />";
#$repository->getInstance()->read();
$repository->getInstance();
$repository = new Repository(Repository::$REPO_COOKIE);

echo $repository->getInstance()->getInfo() . "<br />";
echo $repository->getInstance()->getInfo() . "<br />";
#echo $repository->getInstance()->read();

$repository = new Repository(Repository::$REPO_SESSION);
#echo $repository->getInstance()->getInfo() . "<br />";

$repository = new Repository(Repository::$REPO_SESSION);
#echo $repository->getInstance()->getInfo() . "<br />";

$repository = new Repository(Repository::$REPO_SESSION);
#echo $repository->getInstance()->getInfo() . "<br />";
$repository = new Repository(Repository::$REPO_SESSION);
#echo $repository->getInstance()->getInfo() . "<br />";

$repository = new Repository(Repository::$REPO_SESSION);
#echo $repository->getInstance()->getInfo() . "<br />";

$repository = new Repository(Repository::$REPO_SESSION);
$repository->getInstance()->write("user", "base", array('name'=>'Topaloglu', 'vorname'=>'Süleyman'));

// $repository->getInstance()->setFetchType(SRepository::FETCH_TYPE_OBJECT);
/*
try
{
        echo $repository->getInstance()->read("user", "base")->name();

} catch (Exception $exc){
        echo $exc->getMessage();
}
*/

// echo $repository->getInstance()->read("user", "base")->vorname;
#highlight_string(var_export($repository->getInstance()->readAll(), true));

#print_r($_SESSION);
#print_r($repository->getInstance()->readAll());

#highlight_string(var_export($_COOKIE, true));

$repo = new Repository(Repository::REPO_SESSION);

#write($repo);

function write($repo){

        $repo->getInstance()
                ->add("user", "musti", array("name"=>"Mustafa", "dogum"=>"13.05.1980", "vize"=>"01.01.2012", "language"=>array("english"=>"goog", "german"=>"Perfekt")))
                ->add("user", "Maho", array("name"=>"Maho", "dogum"=>"13.05.1980", "vize"=>"01.01.2012", "language"=>array("english"=>"goog", "german"=>"Perfekt")))
                ->add("user", "Maho", array("name"=>"MahoAga", "dogum"=>"13.05.1980", "vize"=>"01.01.2012", "language"=>array("english"=>"goog", "german"=>"Perfekt")))
                ->add("user", "Hasan", array("name"=>"Hasan", "dogum"=>"13.05.1980", "vize"=>"01.01.2012", "language"=>array("english"=>"goog", "german"=>"Perfekt")))
                ->add("role", array("name"=>"Player", "start"=>"13.05.1980", "until"=>"01.01.2012"))
                ->add("school","Oxford" )
                // ->add("school","Istanbul" )
                ->add("user", "Osman", array("name"=>"Osman", "dogum"=>"13.05.1980", "vize"=>"01.01.2012", "language"=>array("english"=>"goog", "german"=>"Perfekt")))
                ->add("user", "Süleyman", array("name"=>"Süleyman", "dogum"=>"13.05.1980", "vize"=>"01.01.2012", "language"=>array("english"=>"goog", "german"=>"Perfekt")))
                ->commit();

}











#$repo->getInstance()->killAll();
// Array Mode
#$repo->getInstance()->kill("role");
#$repo->getInstance()->kill("role");
#$repo->getInstance()->kill("user", "Maho");
#$repo->getInstance()->killAll();

#highlight_string(var_export($_COOKIE, true));

#print_r($_COOKIE);

$repo->getInstance()->setFetchMethod(CRepository::FETCH_TYPE_OBJECT);
#highlight_string(var_export($repo->getInstance()->readAll(), true)); ;
#highlight_string(var_export($repo->getInstance()->readAll(), true)); ;
#$repo->getInstance()->read("user");

#highlight_string(var_export($_COOKIE["user"], true));


echo $repo->getInstance()->readAll()->school;
#echo $repo->getInstance()->read("user", "musti")->name;


#
/*
setcookie('users','suleyman', time() + 3600, '/');
setcookie('users','suleymas', time() + 3600, '/');
setcookie('role','123', time() + 3600, '/');


*/
#highlight_string(var_export($_SESSION, true));
