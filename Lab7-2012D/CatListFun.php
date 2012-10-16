<?php
include('Cat.php');

          $cat1 = new Cat;
          $cat1->setColor("black");
          $cat1->setBreed("Calico");
          $cat1->setname("Zoe");
          $myCats[] = $cat1;
          
          $cat2 = new Cat;
          $cat2->setColor("orange");
          $cat2->setBreed("Siamese");
          $cat2->setname("Garfield");
          $myCats[] = $cat2;
          
          $cat3 = new Cat;
          $cat3->setColor("tabby");
          $cat3->setBreed("Lion");
          $cat3->setname("Fluffy");
          $myCats[] = $cat3;

          displayCatInfo($cat1);
          displayCatInfo($cat2);
          displayCatInfo($cat3);
         
          
          echo "The number of cats of color orange is " . countByColor("orange",$myCats);

          
          function displayCatInfo($catExample)
          {
                echo "Name: " . $catExample->getName();
                echo "<br>";
                echo "Color: " . $catExample->getColor();
                echo "<br>";
                echo "Breed: " . $catExample->getBreed();
                echo "<br>";
                echo "<br>";
          }
          
          function countByColor($color,$myCats)//string,array
          {
              $count;//int
              $size=sizeof($myCats);//int
              foreach ($myCats as $item)
              {
                  if($item->getColor()==$color)//if array index at i is same as color
                  {
                      $count++;
                  }
              }
              return $count;              
          }
?>
