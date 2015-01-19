
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>


@include('mecha::partials.js_and_css', array('skip' => \Config::get('mecha::skip', array())))

<style type="text/css">

#moe-login .button{
  width:100px;
  background:#3399cc;
  display:block;
  margin:0 auto;
  margin-top:1%;
  padding:10px;
  text-align:center;
  text-decoration:none;
  color:#fff;
  cursor:pointer;
  transition:background .3s;
  -webkit-transition:background .3s;
}

#moe-login .button:hover{
  background:#2288bb;
}

#moe-login {
  width:400px;
  margin:0 auto;
  margin-top:8px;
  margin-bottom:2%;
  transition:opacity 1s;
  -webkit-transition:opacity 1s;
}


#moe-login h1{
  font-family:'Open Sans',sans-serif;
  background:#3399cc;
  padding:20px 0;
  font-size:140%;
  font-weight:300;
  text-align:center;
  color:#fff;
  margin: 0;
}

#moe-login form{
  background:#DADEEA;
  padding:6% 4%;
}

#moe-login input[type="text"],#moe-login input[type="password"]{
  width: 100%;
  background:#fff;
  margin-bottom:4%;
  border:1px solid #ccc;
  padding:4%;
  font-family:'Open Sans',sans-serif;
  font-size:95%;
  color:#555;
}

#moe-login input[type="submit"]{
  width:100%;
  background:#3399cc;
  border:0;
  padding:4%;
  font-family:'Open Sans',sans-serif;
  font-size:100%;
  color:#fff;
  cursor:pointer;
  transition:background .3s;
  -webkit-transition:background .3s;
}

#moe-login input[type="submit"]:hover{
  background:#2288bb;
}
</style>







<div id="moe-login">
  <h1>MOE Auth</h1>
  <form id="moe-login-form" onsubmit="Mecha.doAuth(); return false;">
    <input name="login" type="text" placeholder="Login" />
    <input name="pass" type="password" placeholder="Password" />
    <input type="submit" value="Auth" />
  </form>
</div>

