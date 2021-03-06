<?php        
require_once '/google/src/Google/autoload.php'; 
require_once '/google/src/Google/Client.php';     
require_once '/google/src/Google/Service/Analytics.php';            
$client = new Google_Client();
    $client->setApplicationName("elibrary");
    $client->setDeveloperKey("AIzaSyDz0CnQzPTQN6pu171VvIyCY3ZZ1vuZkPU");  
    $client->setClientId('85666748912-kff12upb0ti7012n2bqq82j9ou1rflbq.apps.googleusercontent.com');
    $client->setClientSecret('3F3mFjPTeDcUNcr7BFYgwgtn');
    $client->setRedirectUri('http://localhost/e-BookStore-MEDT-/google/homepage.php');	//Startseite verlinken
    $client->setScopes(array('https://www.googleapis.com/auth/analytics.readonly'));

    //For loging out.
    if ($_GET['logout'] == "1") {
	unset($_SESSION['token']);
       }   

    // Step 2: The user accepted your access now you need to exchange it.
    if (isset($_GET['code'])) {
        
    	$client->authenticate($_GET['code']);  
    	$_SESSION['token'] = $client->getAccessToken();
    	$redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
    	header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
    }

    // Step 1:  The user has not authenticated we give them a link to login    
    if (!$client->getAccessToken() && !isset($_SESSION['token'])) {
    	$authUrl = $client->createAuthUrl();
    	print "<a class='login' href='$authUrl'><img src='google.png'></a>";
        }        

    // Step 3: We have access we can now create our service
    if (isset($_SESSION['token'])) {
        print "<a class='logout' href='".$_SERVER['PHP_SELF']."?logout=1'><img src='google.png'></a><br>";
    	$client->setAccessToken($_SESSION['token']);
    	$service = new Google_Service_Analytics($client);    

        // request user accounts
        $accounts = $service->management_accountSummaries->listManagementAccountSummaries();

       foreach ($accounts->getItems() as $item) {
		echo "Account: ",$item['name'], "  " , $item['id'], "<br /> \n";		
		foreach($item->getWebProperties() as $wp) {
			echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;WebProperty: ' ,$wp['name'], "  " , $wp['id'], "<br /> \n";    
			
			$views = $wp->getProfiles();
			if (!is_null($views)) {
				foreach($wp->getProfiles() as $view) {
				//	echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;View: ' ,$view['name'], "  " , $view['id'], "<br /> \n";    
				}
			}
		}
	} // closes account summaries

    }
 print "<br><br><br>";
// print "Access from google: " . $_SESSION['token']; 
?>