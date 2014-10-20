<!doctype html>
<html>
	<body>
		<pre>
<?php
include 'AsciiTable.php';
$array = array(
    array(
        'Name' => 'Trixie',
        'Color' => 'Green',
        'Element' => 'Earth',
        'Likes' => 'Flowers'
    ),
    array(
        'Name' => 'Tinkerbell',
        'Element' => 'Air',
        'Likes' => 'Singning',
        'Color' => 'Blue'
    ), 
    array(
        'Element' => 'Water',
        'Likes' => 'Dancing',
        'Name' => 'Blum',
        'Color' => 'Pink'
    )
);
$table = new AsciiTable($array);
$table->set_column_colors(array(
	'Name' => '#FF8F8F',
	'Color' => '#FFF98F',
	'Element' => '#8FFF9D',
	'Likes' => '#8FE1FF'
));
echo $table->get_rendered_table_string();
?>
		</pre>
	</body>
</html>