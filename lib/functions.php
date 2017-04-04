<?php namespace ugotbook;
include_once 'sierra-api-client/Sierra.php'; use Sierra;

/*
* API class -- a class for API call functions
*/
class API {
  // API class constructor
  public function __construct($endpoint, $key, $secret) {
    $this->connection = new Sierra(array(
      'endpoint' => $endpoint,
      'key' => $key,
      'secret' => $secret
    ));
  }
  
  // fetch a patron, given a barcode
  public function fetchPatron($bcode) {
    return $this->connection->query('patrons/find?barcode=' . $bcode . '&fields=id%2Cnames%2Cemails%2CbirthDate%2ChomeLibraryCode', array(), false);
  }
  
  // request a hold on behalf of a patron
  public function requestHold($patron, $bib_id) {
    
    // create an array to be encoded to json for POST body
    $hold_object = Array(
      'recordType' => 'b',
      'recordNumber' => $bib_id,
      'pickupLocation' => $patron['homeLibraryCode']
    );
  }
   // Send e-mail notification to patron
  public function emailPatron($patron, $bib_id) {
    
    $to = $patron['emails'][1];
    $homelibrary = $patron['homeLibraryCode'];

    if (preg_match("/.*@.*\..*/", $to) > 0) {

        $subject = 'You got Book!';
        $message = 'A book you requested has arrived and a hold has been placed on your behalf';
        $headers = 'From: UGOTBOOK@batmanlibrary.com';

    mail($to, $subject, $message, $headers);

    } else {

    echo "No email found in patron record, hold was placed anyway";
  }
}

/*
* DNA class -- a class for Sierra DNA related call functions
*/
class DNA {
  public function __construct() {
    
  }
  
  public function __destruct() {
    
  }
}
