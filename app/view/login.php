<?php
$fs = new Firestore('users');

if(isset($_GET['action']) && $_GET['action']=='logout'){
    $_SESSION['is_online'] = 0;
    session_destroy();
    echo "Zostałeś pomyślnie wylogowany.";
}
if(isset($_SESSION['is_online'])){
    if($_SESSION['is_online']==1 && (time()-$_SESSION['time']>10*60)){
        $_SESSION['is_online']=0;
        session_destroy();
        echo "Sesja zakończona, zbyt długa nieczynność.";
    }
    if($_SESSION['is_online']==1 && ($_SESSION['user_agent']!=$_SERVER['HTTP_USER_AGENT'])){
        $_SESSION['is_online']=0;
        session_destroy();
        echo "Prosimy o ponowne zalogowanie się.";
    }
} else $_SESSION['is_online']=0;

if((isset($_POST['login']) && isset($_POST['password'])) || $_SESSION['is_online']==1){
    if((!empty($_POST['login']) && !empty($_POST['password'])) || $_SESSION['is_online']==1){
        if($_SESSION['is_online']==0){
            $login      = filter_var($_POST['login'],   FILTER_SANITIZE_STRING);
            $password   = filter_var($_POST['password'],FILTER_SANITIZE_STRING);
            $user = $fs->getDocument($login);
        }
        dump(password_verify($password, $user['password']));
        if(password_verify($password, $user['password']) || $_SESSION['is_online']==1){
            if($_SESSION['is_online']==0){
                $_SESSION['login']=$login;
            }

            $_SESSION['is_online']=1;
            $_SESSION['time']=time();
            $_SESSION['user_agent']=$_SERVER['HTTP_USER_AGENT'];

            setcookie('url', null, -1, '/');
            setcookie('url', 'chat.php', 0);
            header("Location: public.php");
        } else
            echo "Podałeś niepoprawny login lub hasło. Spróbuj ponownie.";
    } else
        echo "Nie podałeś loginu lub hasła. Spróbuj ponownie.";
}

if($_SESSION['is_online']==0)
{
?>
<h1>ExamPLE</h1>
<h2>Logowanie</h2>
<form action="../layout/public.php" method="post" id="sign-in">
    <input type="text" name="login" maxlength="20" placeholder="Login" /><br>
    <input type="password" name="password" maxlength="40" placeholder="Hasło" /><br>
    <input type="submit" value="Zaloguj"/>
</form>
<?php } ?>