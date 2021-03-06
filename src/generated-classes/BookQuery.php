<?php

use Base\BookQuery as BaseBookQuery;
use Propel\Runtime\Propel;

/**
 * Skeleton subclass for performing query and update operations on the 'book' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class BookQuery extends BaseBookQuery
{
  /*
    Delete-Funktion um ein File aus dem Server und den dazugehoerigen DB-Eintrag zu loeschen
    Autor: lzainzinger
    Version: 2015-05-19
  */
  function deleteFromServer($id){
    if(BookQuery::create()->findOneByBookId($id)){
      $book = BookQuery::create()->findOneByBookId($id);
      $file = $book->getPath();
    }else{
      echo ("File does not exist!");
    }

  // Loeschen des Files vom Server
    if (!unlink($file)) // Loeschen des Files vom Server und ueberpruefung
    {
      echo ("Error deleting $file"); // Ausgabe bei Error
    }
    else
    {
      // Loeschen des Datenbank - Eintrages
      $book->delete(); // Loeschen DB
      echo ("Deleted $file"); // Ausgabe wenn Erfolgreich
    }
  }

  /*
    Download-Funktion um ein File aus dem Server und den dazugehoerigen DB-Eintrag zu loeschen
    Autor: lzainzinger
    Version: 2015-05-19
  */
  function downloadFromServer($id){
    if(BookQuery::create()->findOneByBookId($id)){
      $book = BookQuery::create()->findOneByBookId($id);
      $file = $book->getPath();
    }else{
      echo ("ID does not exist!");
    }

    echo '<a href="'.$file.'">zum Download</a>'; //Ausgabe des Pfades zum File fuer den Download
  }

/*
Aenderungs-Funktion um Eintraege eines Buches zu aendern
Autor: sarah kreutzer
Version: 2015-05-13
*/
  function edit($book_id,$title,$author,$genre,$publisher,$language,$content,$year){
    if(BookQuery::create()->findOneByBookId($book_id)){
      $book = BookQuery::create()->findOneByBookId($book_id);
    }else{
      echo 'id not found!';
    }
//keine ueberpruefung ob leer oder null notwendig,da dies schon Propel uebernimmt
      $book->setTitle($title);
      $book->setAuthor($author);
      $book->setGenre($genre);
      $book->setPublisher($publisher);
      $book->setLanguage($language);
      $book->setContent($content);
      $book->setYear($year);
      if ($book->save()){
        $book->save();
        echo 'geandert';
      }else{
        echo 'fail,keine Aenderung moeglich';
      }
  }



  //Diese Methode funktioniert nicht. Er befuellt zwar rs aber gibt kein Array zurueck
  //Such-Funktion um Buecher zu suchen
  //Return: Buch-Array
  //Autor: lzainzinger, sarah kreutzer
  //Version: 2015-05-19

  function search($i){
    $con = Propel::getWriteConnection(\Map\BookTableMap::DATABASE_NAME);
    $sql = "SELECT * FROM book WHERE title LIKE '%$i%';";
    $stmt = $con->prepare($sql);
    $rs=$stmt->executeQuery();
    $array=mysqli_fetch_array($rs,MYSQLi_num);
    return $array;
  }
  */

}
