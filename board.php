<?php

$v = urldecode($_REQUEST['vector']);
#$v = 'sol,name=0.07936855820532118,m=9,n=10:o,2,o,2,o,2,o,2,o,1,2,o,2,o,2,o,2,o,2,o,o,3,o,3,o,2,o,2,o,2,2,o,3,o,2,o,2,o,3,o,o,2,o,1,o,2,o,2,o,2,2,o,1,o,2,o,3,o,2,o,o,2,o,2,o,3,o,3,o,2,2,o,1,o,3,o,2,o,3,o,o,1,o,2,o,1,o,1,o,1,';

if ($_REQUEST['fmt']) {
    $fmt = urldecode($_REQUEST['fmt']);
} else {
    $fmt = "quadratic";
    $fmt = "triangular";
}
if ($_REQUEST['d']) {
    $d = urldecode($_REQUEST['d']);
} else {
    $d = 35;
}

$pat = '(mines|sol),name=([^,]+),m=([0-9]+),n=([0-9]+):([0-9\*,\o\-_\?]+)$';

ereg($pat,$v,$regs);

$name = $regs[2];
$m = $regs[3];
$n = $regs[4];
$brd = $regs[5];

$bord = split( ",", $brd);

$board = array();

for ($i = 0; $i<$m; $i++) {
    for ($j = 0; $j < $n; $j++ ) {
        $board[$i][$j] = $bord[$i*$n + $j];
        if ($board[$i][$j]==='_') $board[$i][$j] = '-';
    }
}

//print_r($board);
//exit;

/*$board = array();
$board[0][0] = '1';
$board[0][1] = '';
$board[1][0] = '*';
$board[1][1] = '?';
*/

$nx = (count($board,1)/count($board,0) - 1);
$ny = count($board,0);

if ($fmt=="quadratic") 
{
$cellwidth = $d*50/35;
$cellheight = $d*50/35;
$cellborder = 3;
$boardborder = 3;

$im_side_x = 2*$boardborder + $nx*($cellwidth + $cellborder) - $cellborder;
$im_side_y = 2*$boardborder + $ny*($cellwidth + $cellborder) - $cellborder;


$im = imagecreatetruecolor( $im_side_x, $im_side_y );
$white = imagecolorallocate($im, 255, 255, 255);
$textcolor = imagecolorallocate($im, 170,10, 10);
putenv('GDFONTPATH=' . realpath('.'));
$font_file = './FreeSansBold.ttf';
$font_size = 16*$d/35;

for ($i = 0; $i < $ny; $i++) {
    for ($j = 0; $j < $nx; $j++ ) {   
        $x1 = $boardborder + $j*($cellwidth + $cellborder);
        $y1 = $boardborder + $i*($cellwidth + $cellborder);
        $x2 = $boardborder + ($j+1)*($cellwidth + $cellborder) - $cellborder;
        $y2 = $boardborder + ($i+1)*($cellwidth + $cellborder) - $cellborder;

        imagefilledrectangle($im, $x1,$y1,$x2,$y2, $white);       

        imagettftext($im, $font_size, 0, ($x1+$x2-$font_size/2)/2, ($y1+$y2+$font_size)/2, $textcolor, $font_file, $board[$i][$j]);
//        imagestring($im, 5, ($x1+$x2-$cellborder)/2, ($y1+$y2-$cellborder)/2, $board[$i][$j], $textcolor);
    }
}

}
else if ($fmt == "triangular") 
{

$im_side_x = $d*($nx+2)*sqrt(3);
$im_side_y = $d*($ny+2);

$im = imagecreatetruecolor( $im_side_x, $im_side_y );
$white = imagecolorallocate($im, 255, 255, 255);
$textcolor = imagecolorallocate($im, 170,10, 10);
putenv('GDFONTPATH=' . realpath('.'));
$font_file = './FreeSansBold.ttf';
$font_size = 16*$d/35;

imagefilledrectangle($im, 0,0,$im_side_x,$im_side_y, $white);

for ($i = 1; $i <= $ny; $i++) {
    for ($j = 1; $j <= $nx; $j++ ) {

        $b[$i][$j]['y'] = $d*$i ;
        $b[$i][$j]['x'] = $d*sqrt(3)*$j;

    if (($i + $j) % 2 == 0) {
        $a[$i][$j][1]['y'] = $d*$i;
        $a[$i][$j][1]['x'] = $d*sqrt(3)*($j-1/2);
        $a[$i][$j][2]['y'] = $d*($i+1);
        $a[$i][$j][2]['x'] = $d*sqrt(3)*($j+1/2);
        $a[$i][$j][3]['y'] = $d*($i-1);
        $a[$i][$j][3]['x'] = $d*sqrt(3)*($j+1/2);
        imageline($im, $a[$i][$j][1]['x'], $a[$i][$j][1]['y'], $a[$i][$j][2]['x'], $a[$i][$j][2]['y'], $textcolor);
        imageline($im, $a[$i][$j][2]['x'], $a[$i][$j][2]['y'], $a[$i][$j][3]['x'], $a[$i][$j][3]['y'], $textcolor);
        imageline($im, $a[$i][$j][3]['x'], $a[$i][$j][3]['y'], $a[$i][$j][1]['x'], $a[$i][$j][1]['y'], $textcolor);
    }

    if ( ($i % 2 == 0) && ($j == 1) ) {
        imageline($im, $d*sqrt(3)*(1/2), $d*($i-1), $d*sqrt(3)*(1/2), $d*($i+1), $textcolor);
    }

    if ( ($j % 2 == 0) && ($i == 1) ) {
        imageline($im, $d*sqrt(3)*($j-1/2), 0, $d*sqrt(3)*($j+1/2), $d, $textcolor);
    }

    if ( ($j % 2 != 0) && ($i == $ny) ) { 
        if ($i % 2 == 0) {
            imageline($im, $d*sqrt(3)*($j-1/2), $d*($ny+1), $d*sqrt(3)*($j+1/2), $d*$ny, $textcolor);
        }
    } 
    else if ( ($j % 2 == 0) && ($i == $ny) ) {
        if ($i % 2 != 0) {
            imageline($im, $d*sqrt(3)*($j-1/2), $d*($ny+1), $d*sqrt(3)*($j+1/2), $d*$ny, $textcolor);
        }
    }

        $x1 = $b[$i][$j]['x'];
        $y1 = $b[$i][$j]['y'];
        if (($i + $j) % 2 != 0) {
            $x1 = $x1 - $d/3;
//           $y1 = $y1 - $d/10;
        }
        else {
            $x1 = $x1 + $d/10;
        }
        $y1 = $y1 - $d/5;
        $x1 = $x1 + $d/6;

        imagettftext($im, $font_size, 0, $x1-$font_size/2, $y1+$font_size, $textcolor, $font_file, $board[$i-1][$j-1]);

    }
}

}





header('Content-type: image/png');
imagepng($im);


?>







