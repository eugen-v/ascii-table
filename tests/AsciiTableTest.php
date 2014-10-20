<?php

class AsciiTableTests extends PHPUnit_Framework_TestCase {
	private $array1 = array(
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
	    ),
	);
	private $array2 = array(
	    array(
	        'LongestColumnName' => 'Trixie',
	        'Color' => 'Green',
	        'Element' => 'Earth',
	        'Likes' => 'Flowers'
	    ),
	    array(
	        'LongestColumnName' => 'Tinkerbell',
	        'Element' => 'Air',
	        'Likes' => 'Singning',
	        'Color' => 'Blue'
	    ), 
	    array(
	        'Element' => 'Water',
	        'Likes' => 'Dancing',
	        'LongestColumnName' => 'Blum',
	        'Color' => 'Pink'
	    ),
	);

	public function testRowWidth() {
		$table1 = new AsciiTable($this->array1);
		$this->assertEquals(12, $table1->get_required_cell_width(), 'long cell');

		$table2 = new AsciiTable($this->array2);
		$this->assertEquals(19, $table2->get_required_cell_width(), 'long column title');
	}

	public function testTableSizes() {
		$table = new AsciiTable($this->array1);
		$this->assertEquals(3, $table->get_num_of_rows(), 'number of rows in table');
		$this->assertEquals(4, $table->get_num_of_columns(), 'number of columns in table');
	}

	public function testRender() {
		$table = new AsciiTable($this->array1);
		$this->assertEquals("+------------+------------+------------+------------+\n| Name       | Color      | Element    | Likes      |\n+------------+------------+------------+------------+\n| Trixie     | Green      | Earth      | Flowers    |\n| Tinkerbell | Blue       | Air        | Singning   |\n| Blum       | Pink       | Water      | Dancing    |\n+------------+------------+------------+------------+\n", $table->get_rendered_table_string(), 'test render without color');

		$table_color = new AsciiTable($this->array1);
		$table_color->set_column_colors(array(
			'Name' => '#FF8F8F',
	        'Color' => '#FFF98F',
	        'Element' => '#8FFF9D',
	        'Likes' => '#8FE1FF'
		));
		$this->assertEquals("+------------+------------+------------+------------+\n|<span style=\"background-color: #FF8F8F\"> Name       </span>|<span style=\"background-color: #FFF98F\"> Color      </span>|<span style=\"background-color: #8FFF9D\"> Element    </span>|<span style=\"background-color: #8FE1FF\"> Likes      </span>|\n+------------+------------+------------+------------+\n|<span style=\"background-color: #FF8F8F\"> Trixie     </span>|<span style=\"background-color: #FFF98F\"> Green      </span>|<span style=\"background-color: #8FFF9D\"> Earth      </span>|<span style=\"background-color: #8FE1FF\"> Flowers    </span>|\n|<span style=\"background-color: #FF8F8F\"> Tinkerbell </span>|<span style=\"background-color: #FFF98F\"> Blue       </span>|<span style=\"background-color: #8FFF9D\"> Air        </span>|<span style=\"background-color: #8FE1FF\"> Singning   </span>|\n|<span style=\"background-color: #FF8F8F\"> Blum       </span>|<span style=\"background-color: #FFF98F\"> Pink       </span>|<span style=\"background-color: #8FFF9D\"> Water      </span>|<span style=\"background-color: #8FE1FF\"> Dancing    </span>|\n+------------+------------+------------+------------+\n", $table_color->get_rendered_table_string(), 'test render with color');
	}

	public function testRenderInvalidInput() {
		$table = new AsciiTable(array());
		$this->assertEquals('', $table->get_rendered_table_string(), 'render empty table');

		$table2 = new AsciiTable(array(
			array(
		        'Name' => 'Trixie',
		        'Color' => 'Green',
		        'Element' => 'Earth',
		        'Likes' => 'Flowers'
		    ),
		    array(
		        'Name' => 'Tinkerbell',
		        'Nothing' => 'Air', // this column doesn't exist
		        'Likes' => 'Singning',
		        'Color' => 'Blue'
		    )
		));
		$this->assertEquals("+------------+------------+------------+------------+\n| Name       | Color      | Element    | Likes      |\n+------------+------------+------------+------------+\n| Trixie     | Green      | Earth      | Flowers    |\n| Tinkerbell | Blue       |            | Singning   |\n+------------+------------+------------+------------+\n", $table2->get_rendered_table_string(), 'render table with missing data');
	}
}

?>