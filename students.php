<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Studentai PHP</title>
    <style>
        body {
            background-image: url('https://visme.co/blog/wp-content/uploads/2017/07/50-Beautiful-and-Minimalist-Presentation-Backgrounds-040.jpg');
            background-repeat: no-repeat;
            background-size: cover;
        }
        .container {
            max-width: 1000px;
            margin: 20px auto;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }
        p {
            margin: 0;
            padding: 0;
            font-size: 1.2rem;
            border: 2px solid black;
            border-radius: 20px;
            padding: 15px;
            width: 320px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .asoc {
            border: 2px solid black;
            border-radius: 20px;
            padding: 15px;
        }
    button {
    max-width: 100px;
    padding: 15px;
    background-color: green;
    color: white;
    border-radius: 15px;
    border: none;
    align-self: center;
}
table {
  justify-content: center;
  border: 1px solid black;
  border-radius: 10px;
  padding: 5px;
  box-shadow: 5px 11px 68px 1px rgba(0,0,0,0.87);
-webkit-box-shadow: 5px 11px 68px 1px rgba(0,0,0,0.87);
-moz-box-shadow: 5px 11px 68px 1px rgba(0,0,0,0.87);
}

th,
td {
  border-radius: 10px;
  height: 30px;
  text-align: center;
  font-size: 1.2rem;
}


tr:nth-child(even) {
  background-color: lightgrey;
}

    </style>
</head>

<body>
    <div class="container">
        <h1>Studentų forma</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="upload" value="1">
            <input type="file" name="failas">
            <button>Išsiųsti</button>
        </form>
        
        <?php 
        
        if (isset($_POST['upload'])) {
            move_uploaded_file(
                $_FILES['failas']['tmp_name'],
                'C:/xampp/htdocs/StudentuVidurkiaiUzduotis/' . $_FILES['failas']['name']
            );

            $failas = 'C:/xampp/htdocs/StudentuVidurkiaiUzduotis/' . $_FILES['failas']['name'];
            $f = fopen($failas, "r");

            $studentai = [];
            $vardas = [];
            $pazymiai = [];
            $count = 0;
            $balai = 0;
            $avg = 0;
            $vidurkiuSuma = 0;
            $nr = 0; 
            $min = 100;
            $max = 0;
            $avg5 = 0;
            $pazymiuSuma = 0;

            echo'<h1>Studentų sąrašas:</h1>';
            while ($eilute = fgets($f)) {
                $count++;
                $studentas = explode(',', $eilute);
                $vardas = $studentas[0];
                $baluSuma = 0;
                $pazymiuKiekis = 0;
                foreach ($studentas as $pazymiai) {
                    if (is_numeric($pazymiai)) {
                        $baluSuma += $pazymiai;
                        $pazymiuKiekis++;     
                                                            
                    }
                   
                }   
                if ($min > $pazymiuKiekis) {
                    $min = $pazymiuKiekis;
                    $min1 = $vardas;
                }
                if ($max < $pazymiuKiekis) {
                    $max = $pazymiuKiekis;
                    $max1 = $vardas;
                } 
        

                $avg = $baluSuma / $pazymiuKiekis;
                
               
                $studentai[$vardas] = round($avg, 2);
                $student[$vardas] = $pazymiuKiekis;
               echo'<br>';
               
            echo '<p>'.$vardas. ' vid. ' . ' <strong>'.round($avg, 2),'</strong>'.'</p>';
                
            }
                     

            foreach($studentai as $index=>$value){
                $vidurkiuSuma += $value;
            }

            $vid = $vidurkiuSuma / $count;

            foreach($student as $index=>$value){
                $pazymiuSuma += $value;
            }
            $vidPazKiekis = $pazymiuSuma/$count;
            
            

          
            echo '<hr>';
            echo'<div class="asoc">';
            print_r ($studentai);
            echo'</div>';
            echo '<br>';
            echo '<p>Turime ' . $count . ' studentų grupėje</p>';
            echo '<br>';
            echo '<p>Visų vaikų balų vidurkis: '.round($vid, 2).'</p>';
            echo '<br>';
                     
            echo '<p>Mažiausiai pažymių gavo: '.$min1.' ir jo(-os) pažymių suma: ' .$min.'</p>';
            echo '<br>';
            echo '<p>Daugiausiai pažymių gavo: '.$max1. ' ir jo(-os) pažymių suma: '.$max.'</p>';  
            echo'<br>';
            echo '<p>Vidutiniškai gaunamų pažymių per semestrą: '.round($vidPazKiekis, 2).'</p>';  
            echo'<br>';
            fclose($f);
          
            

          echo'  <h1>Egzaminų perlaikytojų sąrašas</h1>
     <table>
            <thead>
            <td>Eil. Nr.</td>  
             <td>Vardas</td>  
             <td>Vidurkis</td>
            </thead>
            <tbody>
            <tr>';
            $nr = 1;
               foreach($studentai as $index=>$value){
                if ($value<5) { 
                echo'<td>'.$nr++.'</td>';
                 echo'<td>'.$index.'</td>';
                echo' <td>'.$value.'</td>';
                } 
             echo'  </tr>';
           }
             
            echo' </tbody>
            </table>';

           echo' <h1>Gaunančių stipendiją sąrašas</h1>
     <table>
            <thead>
            <td>Eil. Nr.</td> 
             <td>Vardas</td>  
             <td>Vidurkis</td>
            </thead>
            <tbody>
            <tr>';
            $nr = 1;
            foreach($studentai as $index=>$value){
                if ($value>8.5) { 
                    echo'<td>'.$nr++.'</td>';
                echo' <td>'.$index.'</td>';
                echo' <td>'. $value.'</td>';
                } 
               echo '</tr>';
            }
             
          echo'   </tbody>
            </table>';
          
    
        }
        ?>
     
               
    </div>

</body>

</html>