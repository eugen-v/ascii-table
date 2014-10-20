<?php
class AsciiTable {
	private $data, $column_titles, $num_of_columns, $num_of_rows, $column_colors, $has_column_colors;

	public function __construct($data) {
		$this->data = $data;
		$this->has_column_colors = FALSE;

		$this->num_of_rows = count($data);
		
		if($this->num_of_rows > 0) {
			$this->column_titles = array_keys($data[0]);
		}
		
		$this->num_of_columns = count($this->column_titles);
	}

	/**
	 * If called before get_rendered_table_string(), then columns will be colored. Otherwise, they won't.
	 * @param $column_colors Associative array with column names as keys and hex colors as values.
	 */
	public function set_column_colors($column_colors) {
		$this->has_column_colors = TRUE;
		$this->column_colors = $column_colors;
	}

	/**
	 * Returns the length of the longest word + 2 (padding).
	 */
	public function get_required_cell_width() {
		$len = 0;
		foreach($this->data as $column_index => $column_array) {
			foreach($this->column_titles as $column_title) {
				$current_len = strlen($column_title);
				if($current_len > $len) {
					$len = $current_len;
				}
			}
			foreach($column_array as $column_title => $row) {
				$current_len = strlen($row);
				if($current_len > $len) {
					$len = $current_len;
				}
			}
		}
		return $len + 2;
	}

	public function get_num_of_columns() {
		return $this->num_of_columns;
	}

	public function get_num_of_rows() {
		return $this->num_of_rows;
	}

	public function get_rendered_table_string() {
		if($this->num_of_rows == 0) {
			return '';
		}
		$output = '';
		$column_width = $this->get_required_cell_width();
		
		// -- render top border --
		for($column_index = 0; $column_index < $this->num_of_columns; $column_index++) {
			$output .= '+';
			$output .= str_pad('', $column_width, '-');
		}
		$output .= "+\n";
		$horizontal_table_border = $output; // the top border is identical with the border between the table's header and body, so I'll reuse it.

		// -- render table column names --
		for($column_index = 0; $column_index < $this->num_of_columns; $column_index++) {
			$output .= '|';
			$before_string = ' ';
			$after_string = '';
			if($this->has_column_colors) {
				$before_string = '<span style="background-color: ' . $this->column_colors[$this->column_titles[$column_index]] . '"> ';
				$after_string = '</span>';
			}
			$output .= $before_string . str_pad($this->column_titles[$column_index], $column_width - 1, ' ') . $after_string; // left padding is already added
		}
		$output .= "|\n";

		// -- render border between table header and body --
		$output .= $horizontal_table_border;

		// -- render table body --
		for($row_index = 0; $row_index < $this->num_of_rows; $row_index++) {
			for($column_index = 0; $column_index < $this->num_of_columns; $column_index++) {
				$output .= '|';
				$before_string = ' ';
				$after_string = '';
				if($this->has_column_colors) {
					$before_string = '<span style="background-color: ' . $this->column_colors[$this->column_titles[$column_index]] . '"> ';
					$after_string = '</span>';
				}
				$item_text = '';
				if(isset($this->data[$row_index][$this->column_titles[$column_index]])) {
					$item_text = $this->data[$row_index][$this->column_titles[$column_index]];
				}
				$output .= $before_string . str_pad($item_text, $column_width - 1, ' ') . $after_string; // left padding is already added
			}
			$output .= "|\n";
		}

		// -- render bottom border (ends with \n) --
		$output .= $horizontal_table_border;

		return $output;
	}
}
?>