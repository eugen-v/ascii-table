#Usage
```php
$table = new AsciiTable($array);
// Optionally set columns' colors
$table->set_column_colors(array(
	'Name' => '#FF8F8F',
	'Color' => '#FFF98F',
	'Element' => '#8FFF9D',
	'Likes' => '#8FE1FF'
));
echo $table->get_rendered_table_string();
```

**TIP**: embed the output string in `<pre></pre>` tags.
