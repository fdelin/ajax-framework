<!DOCTYPE html>
<html lang="en">
<head>
  <title>ajax page loading example</title>
  <meta charset="utf-8">
  <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
</head>

<body>
  <ul>
    <li><a class="hijax" href="/">Landing</a></li>
    <li><a class="hijax" href="/one">One</a></li>
    <li><a class="hijax" href="/two">Two</a></li>
    <li><a class="hijax" href="/three">Three</a></li>
  </ul>
  <article id="container">
    <?php
      $page = str_replace('/','_',substr($_SERVER['REQUEST_URI'],1));
      if($page == ''){ $page = 'landing'; }
      include('pages/'.$page.'.html');
    ?>
  </article>

  <script>
    $(function(){

      /********** BROWSER HISTORY MANAGEMENT **********/
      var checkPushstate = {
        available: false,
        check: function(){
          if(!!(window.history && history.pushState)){
            checkPushstate.available = true;
            checkPushstate.yes();
          }else{
            checkPushstate.available = false;
            checkPushstate.no();
          }
        },
        // IF PUSHSTATE IS SUPPORTED, CHECK FOR HASH BANGS IN URL
        yes: function(){
          if(window.location.hash){
            var u = window.location.hash;
            var location = '/' + u.replace('#!/','');
            window.location.replace(location);
          }
        },
        // IF PUSH STATE IS NOT SUPPORTED, CHECK FOR URL PATH
        no: function(){
          var u = window.location.pathname;
          if(u!='' && !window.location.hash){
            var location = '/#!' + u;
            window.location.replace(location);
          }
        }
      };
      checkPushstate.check();

      if(checkPushstate.available!=true) updateFromHistory();
      window.onpopstate   = function(e){ updateFromHistory(); };
      window.onhashchange = function(e){ updateFromHistory(); };




      /********** AJAX LOADER **********/
      function ajaxLoader(fileName){
        console.log("ajaxLoading "+fileName);
        if(fileName == '') fileName = 'landing';
        $('#container').load('/pages/'+fileName+'.html', {}, function() {
          //callback functions
          updateUI(fileName);
        });
      }



      /********** AJAX LOADER - BROWSER HISTORY **********/
      function updateFromHistory(){
        //GET CURRENT URL PATH
        var path;
        if(checkPushstate.available==true) path = window.location.pathname.substring(1);
        else path = window.location.hash.replace('#!/','');

        //CONVERT TO FILE NAME
        var fileName = path.replace(/\//g,'_'); //replace slashes with underscores
        ajaxLoader(fileName);
      }



      /********** CONNECT HIJAX LOADING **********/
      function connectHijaxLoading(){
        //console.log("preparing hijax links");
        $('.hijax').off("click");
        $('.hijax').click(function(){
          var path = $(this).attr('href');
          var fileName = path.substr(1, path.length); //remove first slash
          fileName = fileName.replace(/\//g,'_'); //replace slashes with underscores
          if(checkPushstate.available==true) history.pushState(null, '', '/'+fileName);
          else window.location.hash = '!/'+fileName;
          ajaxLoader(fileName);
          return false; //prevent default click
        });
      }


      connectHijaxLoading();
    });
  </script>

</body>
</html>
