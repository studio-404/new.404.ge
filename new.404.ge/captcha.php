<?php 

class captcha {
	public $base_dir = '';
	public $font_path = 'fonts/';
	public $font = 'Momоt___.ttf';
	public $font_size = 30;
	public $letter_jump_x = 0;
	public $letter_jump_y = 0;
	public $text_start_location = -1;
	public $text_transparency = 0;
	public $code = '';
	public $code_length = 6;
	public $width = 200;
	public $height = 60;
	public $bg_color = '#ffffff';
	public $text_color = '#000000';
	public $noise_color = '#000000';
	public $arc_color = '#000000';
	public $line_color = '#000000';
	public $arc_thickness = 1;
	public $line_thickness = 1;
	public $line_count = 0;
	public $arc_count = 0;
	public $noise_count = 0;
	public $text_distortion = 0;
	public $text_angle = 0;
	private $image;
	private $tmp_image;
	private $rgb_text_color;
	private $rgb_bg_color;
	private $tmp_bg_color = '#ffffff';
	private $rgb_tmp_bg_color;
	private $tmp_text_color = '#000000';
	private $rgb_tmp_text_color;
	private $rgb_noise_color;
	private $rgb_line_color;
	private $rgb_arc_color;

	function __construct() {
		if (session_id() == '') {
			session_start();
		}
	}
	
	function draw() {
		if ($this->base_dir == '') {
			$this->base_dir = $_SERVER['DOCUMENT_ROOT'].'/';
		}
		
		if ($this->code == '') {
			if ($this->code_length > 0) {
				$this->code = $this->generate_code($this->code_length);
			} else {
				throw new InvalidCodeLengthException('The code length must be greater than 0');
			}
		}

		$this->image = imagecreate($this->width, $this->height);
		$this->tmp_image = imagecreate($this->width, $this->height);

		$this->set_colors();

		if ($this->noise_count > 0) {
			$this->draw_noise();
		}

		if ($this->line_count > 0) {
			$this->draw_lines();
		}

		if ($this->arc_count > 0) {
			$this->draw_arcs();
		}

		$this->draw_text();

		if ($this->text_distortion > 0) {
			$this->distort_text();
		}

		$this->output_image();
	}

	private function draw_text() {
		$font = $this->base_dir . $this->font_path . $this->font;
		
		$_SESSION['captchaimg'] = $this->code;

		if (!is_readable($font)) {
			throw new TTFFileUnreadableException('Unable to read given TTF font|'.$font);

		} else {
			$box = imageftbbox($this->font_size, 0, $font, $this->code);

			$img = $this->tmp_image;
			$text_color = $this->rgb_tmp_text_color;
			if ($this->text_distortion <= 0) {
				$img = $this->image;
				$text_color = $this->rgb_text_color;
			}

			$x = $this->text_start_location > -1 ? $this->text_start_location : $this->width / 2 - $box[4] / 2;
			$y = ($this->height - $box[5]) / 2;
			$org_y = $y;

			if ($this->letter_jump_y > 0 || $this->letter_jump_x > 0 || $this->text_angle > 0) {
				for ($i = 0; $i < strlen($this->code); $i++) {
					if ($this->letter_jump_y > 0) {
						$random = rand(0, $this->letter_jump_y);
						$y = ($i % 2) == 0 ? $org_y + $random : $org_y - $random;
					}

					$angle = rand(-$this->text_angle, $this->text_angle);
					$bounding = imagettftext($img, $this->font_size, $angle, $x, $y, $text_color, $font, $this->code[$i]);

					if ($this->letter_jump_x > 0) {
						$tmp_box = imageftbbox($this->font_size, 0, $font, $this->code[$i]);
						$x += $tmp_box[4] + $this->font_size / 10;
						$x += rand(0, $this->letter_jump_x);
					} else {
						$tmp_box = imageftbbox($this->font_size, 0, $font, $this->code[$i]);
						$x += $tmp_box[4] + $this->font_size / 10;
					}
				}
			} else {
				imagettftext($img, $this->font_size, 0, $x, $y, $text_color, $font, $this->code);
			}
		}
	}

	private function draw_noise() {
		for ($i = 0; $i < $this->noise_count; $i++) {
			$x = rand(0, $this->width);
			$y = rand(0, $this->height);
			$size = rand(5, 10);
			if ($x - $size >= 0 && $y - $size >= 0) {
				imagefilledarc($this->image, $x, $y, $size, $size, 0, 360, $this->rgb_noise_color, IMG_ARC_PIE);
			}
		}
	}

	private function draw_lines() {
		for ($i = 0; $i < $this->line_count; $i++) {
			$x1 = rand(0, $this->width);
			$y1 = rand(0, $this->height);
			$x2 = rand(0, $this->width);
			$y2 = rand(0, $this->height);
			imagesetthickness($this->image, $this->line_thickness);
			imageline($this->image, $x1, $y1, $x2, $y2, $this->rgb_line_color);
		}
	}

	private function draw_arcs() {
		for ($i = 0; $i < $this->arc_count; $i++) {
			$x = rand(0, $this->width);
			$y = rand(0, $this->height);
			$width = rand(0, 100);
			$height = rand(0, 100);
			$start = rand(0, 360);
			$end = rand(0, 360);
			imagesetthickness($this->image, $this->arc_thickness);
			imagefilledarc($this->image, $x, $y, $width, $height, $start, $end, $this->rgb_arc_color, IMG_ARC_NOFILL);
		}
	}

	function log($text) {
		$fp = fopen('/tmp/captcha.log', 'a');
		fwrite($fp, $text . "\n");
		fclose($fp);
	}

	private function distort_text() {
		$numpoles = 3;

		for ($i = 0; $i < $numpoles; ++$i) {
			$px[$i] = rand($this->width * 0.2, $this->width * 0.8);
			$py[$i] = rand($this->height * 0.2, $this->height * 0.8);
			$rad[$i] = rand($this->height * 0.2, $this->height * 0.8);
			$tmp = ((- 0.0001 * rand(0, 9999)) * 0.15) - .15;
			$amp[$i] = $this->text_distortion * $tmp;
		}

		$color = imagecolorat($this->tmp_image, 0, 0);

		for ($ix = 0; $ix < $this->width; ++$ix) {
			for ($iy = 0; $iy < $this->height; ++$iy) {

				$x = $ix;
				$y = $iy;

				for ($i = 0; $i < $numpoles; ++$i) {
					$dx = $ix - $px[$i];
					$dy = $iy - $py[$i];
					if ($dx == 0 && $dy == 0) {
						continue;
					}
					$r = sqrt($dx * $dx + $dy * $dy);
					if ($r > $rad[$i]) {
						continue;
					}
					$rscale = $amp[$i] * sin(3.14 * $r / $rad[$i]);
					$x += $dx * $rscale;
					$y += $dy * $rscale;
				}


				$next_pixel = imagecolorat($this->tmp_image, $x, $y);

				if ($next_pixel != $color) {
					imagesetpixel($this->image, $ix, $iy, $this->rgb_text_color);
				}
			}
		}
	}

	private function output_image() {
		if ($this->isHeadersSent()) {
			throw new HeadersSentException("Headers has already been sent, maybe a php error was sent");
		} else {
			header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			header("Cache-Control: no-store, no-cache, must-revalidate");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header('Content-Type: image/jpeg');

			imagejpeg($this->image);
			imagedestroy($this->image);
		}
	}

	private function generate_code($length) {
		$possible = '23456789bcdfghjkmnpqrstvwxyz';
		$code = '';
		$i = 0;
		while ($i < $length) {
			$code .= substr($possible, rand(0, strlen($possible) - 1), 1);
			$i++;
		}
		return $code;
	}

	private function set_colors() {
		try {
			$this->rgb_bg_color = imagecolorallocate(
					$this->image, Color::red($this->bg_color), 
					Color::green($this->bg_color), 
					Color::blue($this->bg_color)
			);

			if ($this->text_transparency > 0) {
				$alpha = intval($this->text_transparency / 100 * 127);
				$this->rgb_text_color = imagecolorallocatealpha(
						$this->image, Color::red($this->text_color), 
						Color::green($this->text_color), 
						Color::blue($this->text_color), 
						$alpha
				);
			} else {
				$this->rgb_text_color = imagecolorallocate(
						$this->image, Color::red($this->text_color), 
						Color::green($this->text_color), 
						Color::blue($this->text_color)
				);
				$this->rgb_noise_color = imagecolorallocate(
						$this->image, Color::red($this->noise_color), 
						Color::green($this->noise_color), 
						Color::blue($this->noise_color)
				);
				$this->rgb_line_color = imagecolorallocate(
						$this->image, Color::red($this->line_color), 
						Color::green($this->line_color), 
						Color::blue($this->line_color)
				);
				$this->rgb_arc_color = imagecolorallocate(
						$this->image, Color::red($this->arc_color), 
						Color::green($this->arc_color), 
						Color::blue($this->arc_color)
				);
			}

			// add colors for temp image
			$this->rgb_tmp_bg_color = imagecolorallocate(
					$this->tmp_image, Color::red($this->tmp_bg_color), Color::green($this->tmp_bg_color), Color::blue($this->tmp_bg_color)
			);
			$this->rgb_tmp_text_color = imagecolorallocate(
					$this->image, Color::red($this->tmp_text_color), Color::green($this->tmp_text_color), Color::blue($this->tmp_text_color)
			);
		} catch (InvalidColorException $e) {
			throw $e;
		}
	}

	private function isHeadersSent() {
		// headers already sent or there is content in the output buffor
		if (headers_sent() === true || (ob_get_contents() !== false && strlen(ob_get_contents()) > 0)) {
			return true;
		}
		return false;
	}
}

class Color {
	public static function red($color) {
		if (substr($color, 0, 1) != '#' && strlen($color) < 7) {
			throw new InvalidColorException('Given color is not a valid hex color code');
		} else {
			return Color::get_color($color, 'red');
		}
	}

	public static function green($color) {
		if (substr($color, 0, 1) != '#' && strlen($color) < 7) {
			throw new InvalidColorException('Given color is not a valid hex color code');
		} else {
			return Color::get_color($color, 'green');
		}
	}

	public static function blue($color) {
		if (substr($color, 0, 1) != '#' && strlen($color) < 7) {
			throw new InvalidColorException('Given color is not a valid hex color code');
		} else {
			return Color::get_color($color, 'blue');
		}
	}

	private static function get_color($color, $additive) {
		$red = 255;
		$green = 255;
		$blue = 255;

		if (substr($color, 0, 1) != '#' && strlen($color) < 7) {
			throw new InvalidColorException('Given color is not a valid hex color code');
		} else {
			$red = hexdec(substr($color, 1, 2));
			$green = hexdec(substr($color, 3, 2));
			$blue = hexdec(substr($color, 5, 2));
		}

		switch ($additive) {
			case 'red':
				return $red;
			case 'green':
				return $green;
			case 'blue':
				return $blue;
			default:
				return 255;
		}
	}
}

class InvalidColorException extends Exception {}
class TTFFileUnreadableException extends Exception {}
class HeadersSentException extends Exception {}
class InvalidCodeLengthException extends Exception {}


$captcha = new captcha();
$captcha->font = 'NotoSans-Regular.ttf';
$captcha->draw();
?>