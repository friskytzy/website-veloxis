<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\UploadedFile;

class ValidImageDimensions implements ValidationRule
{
    protected $minWidth;
    protected $minHeight;
    protected $maxWidth;
    protected $maxHeight;

    public function __construct($minWidth = 300, $minHeight = 300, $maxWidth = 4000, $maxHeight = 4000)
    {
        $this->minWidth = $minWidth;
        $this->minHeight = $minHeight;
        $this->maxWidth = $maxWidth;
        $this->maxHeight = $maxHeight;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$value instanceof UploadedFile) {
            $fail('File harus berupa gambar.');
            return;
        }

        if (!$value->isValid()) {
            $fail('File gambar tidak valid.');
            return;
        }

        $imageInfo = getimagesize($value->getPathname());
        
        if (!$imageInfo) {
            $fail('File harus berupa gambar yang valid.');
            return;
        }

        [$width, $height] = $imageInfo;

        if ($width < $this->minWidth || $height < $this->minHeight) {
            $fail("Dimensi gambar minimal {$this->minWidth}x{$this->minHeight} pixel.");
            return;
        }

        if ($width > $this->maxWidth || $height > $this->maxHeight) {
            $fail("Dimensi gambar maksimal {$this->maxWidth}x{$this->maxHeight} pixel.");
            return;
        }

        // Check aspect ratio (optional)
        $aspectRatio = $width / $height;
        if ($aspectRatio < 0.5 || $aspectRatio > 3) {
            $fail('Rasio aspek gambar tidak valid (terlalu lebar atau terlalu tinggi).');
        }
    }
}
