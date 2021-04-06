<?php

// Konversi Hex ke RGB
if(!function_exists('hex_to_rgb')){
    function hex_to_rgb($code){
        if($code[0] == '#')
            $code = substr($code, 1);

        if(strlen($code) == 3){
            $code = $code[0] . $code[0] . $code[1] . $code[1] . $code[2] . $code[2];
        }

        $r = hexdec($code[0] . $code[1]);
        $g = hexdec($code[2] . $code[3]);
        $b = hexdec($code[4] . $code[5]);

        return $b + ($g << 0x8) + ($r << 0x10);
    }
}

// Konversi RGB ke HSL
if(!function_exists('rgb_to_hsl')){
    function rgb_to_hsl($code){
        $r = 0xFF & ($code >> 0x10);
        $g = 0xFF & ($code >> 0x8);
        $b = 0xFF & $code;

        $r = ((float)$r) / 255.0;
        $g = ((float)$g) / 255.0;
        $b = ((float)$b) / 255.0;

        $maxC = max($r, $g, $b);
        $minC = min($r, $g, $b);

        $l = ($maxC + $minC) / 2.0;

        if($maxC == $minC){
        $s = 0;
        $h = 0;
        }
        else{
            if($l < .5){
                $s = ($maxC - $minC) / ($maxC + $minC);
            }
            else{
                $s = ($maxC - $minC) / (2.0 - $maxC - $minC);
            }

            if($r == $maxC)
                $h = ($g - $b) / ($maxC - $minC);
            if($g == $maxC)
                $h = 2.0 + ($b - $r) / ($maxC - $minC);
            if($b == $maxC)
                $h = 4.0 + ($r - $g) / ($maxC - $minC);

            $h = $h / 6.0; 
        }

        $h = (int)round(255.0 * $h);
        $s = (int)round(255.0 * $s);
        $l = (int)round(255.0 * $l);

        return (object) Array('hue' => $h, 'saturation' => $s, 'lightness' => $l);
    }
}

// Konversi MIME menjadi ekstensi
if(!function_exists('mime_to_ext')){
    function mime_to_ext($mime){
        $mime_map = [
            'video/3gpp2'                                                               => ['3g2', 'file-video', 'Video'],
            'video/3gp'                                                                 => ['3gp', 'file-video', 'Video'],
            'video/3gpp'                                                                => ['3gp', 'file-video', 'Video'],
            'application/x-compressed'                                                  => ['7zip', 'file-archive', 'Arsip'],
            'audio/x-acc'                                                               => ['aac', 'file-audio', 'Audio'],
            'audio/ac3'                                                                 => ['ac3', 'file-audio', 'Audio'],
            'application/postscript'                                                    => ['ai', 'file-alt', 'Lainnya'],
            'audio/x-aiff'                                                              => ['aif', 'file-audio', 'Audio'],
            'audio/aiff'                                                                => ['aif', 'file-audio', 'Audio'],
            'audio/x-au'                                                                => ['au', 'file-audio', 'Audio'],
            'video/x-msvideo'                                                           => ['avi', 'file-video', 'Video'],
            'video/msvideo'                                                             => ['avi', 'file-video', 'Video'],
            'video/avi'                                                                 => ['avi', 'file-video', 'Video'],
            'application/x-troff-msvideo'                                               => ['avi', 'file-video', 'Video'],
            'application/macbinary'                                                     => ['bin', 'file-alt', 'Lainnya', 'Lainnya'],
            'application/mac-binary'                                                    => ['bin', 'file-alt', 'Lainnya'],
            'application/x-binary'                                                      => ['bin', 'file-alt', 'Lainnya'],
            'application/x-macbinary'                                                   => ['bin', 'file-alt', 'Lainnya'],
            'image/bmp'                                                                 => ['bmp', 'file-image', 'Gambar'],
            'image/x-bmp'                                                               => ['bmp', 'file-image', 'Gambar'],
            'image/x-bitmap'                                                            => ['bmp', 'file-image', 'Gambar'],
            'image/x-xbitmap'                                                           => ['bmp', 'file-image', 'Gambar'],
            'image/x-win-bitmap'                                                        => ['bmp', 'file-image', 'Gambar'],
            'image/x-windows-bmp'                                                       => ['bmp', 'file-image', 'Gambar'],
            'image/ms-bmp'                                                              => ['bmp', 'file-image', 'Gambar'],
            'image/x-ms-bmp'                                                            => ['bmp', 'file-image', 'Gambar'],
            'application/bmp'                                                           => ['bmp', 'file-alt', 'Lainnya'],
            'application/x-bmp'                                                         => ['bmp', 'file-alt', 'Lainnya'],
            'application/x-win-bitmap'                                                  => ['bmp', 'file-alt', 'Lainnya'],
            'application/cdr'                                                           => ['cdr', 'file-alt', 'Lainnya'],
            'application/coreldraw'                                                     => ['cdr', 'file-alt', 'Lainnya'],
            'application/x-cdr'                                                         => ['cdr', 'file-alt', 'Lainnya'],
            'application/x-coreldraw'                                                   => ['cdr', 'file-alt', 'Lainnya'],
            'image/cdr'                                                                 => ['cdr', 'file-image', 'Gambar'],
            'image/x-cdr'                                                               => ['cdr', 'file-image', 'Gambar'],
            'zz-application/zz-winassoc-cdr'                                            => ['cdr', 'file-alt', 'Lainnya'],
            'application/mac-compactpro'                                                => ['cpt', 'file-alt', 'Lainnya'],
            'application/pkix-crl'                                                      => ['crl', 'file-alt', 'Lainnya'],
            'application/pkcs-crl'                                                      => ['crl', 'file-alt', 'Lainnya'],
            'application/x-x509-ca-cert'                                                => ['crt', 'file-alt', 'Lainnya'],
            'application/pkix-cert'                                                     => ['crt', 'file-alt', 'Lainnya'],
            'text/css'                                                                  => ['css', 'file-code', 'Source Code'],
            'text/x-comma-separated-values'                                             => ['csv', 'file-excel', 'Spreadsheet'],
            'text/comma-separated-values'                                               => ['csv', 'file-excel', 'Spreadsheet'],
            'application/vnd.msexcel'                                                   => ['csv', 'file-excel', 'Spreadsheet'],
            'application/x-director'                                                    => ['dcr', 'file-alt', 'Lainnya'],
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'   => ['docx', 'file-word', 'Dokumen'],
            'application/x-dvi'                                                         => ['dvi', 'file-alt', 'Lainnya'],
            'message/rfc822'                                                            => ['eml', 'file-alt', 'Lainnya'],
            'application/x-msdownload'                                                  => ['exe', 'file-alt', 'Lainnya'],
            'video/x-f4v'                                                               => ['f4v', 'file-video', 'Video'],
            'audio/x-flac'                                                              => ['flac', 'file-audio', 'Audio'],
            'video/x-flv'                                                               => ['flv', 'file-video', 'Video'],
            'image/gif'                                                                 => ['gif', 'file-image', 'Gambar'],
            'application/gpg-keys'                                                      => ['gpg', 'file-alt', 'Lainnya'],
            'application/x-gtar'                                                        => ['gtar', 'file-archive', 'Arsip'],
            'application/x-gzip'                                                        => ['gzip', 'file-archive', 'Arsip'],
            'application/mac-binhex40'                                                  => ['hqx', 'file-alt', 'Lainnya'],
            'application/mac-binhex'                                                    => ['hqx', 'file-alt', 'Lainnya'],
            'application/x-binhex40'                                                    => ['hqx', 'file-alt', 'Lainnya'],
            'application/x-mac-binhex40'                                                => ['hqx', 'file-alt', 'Lainnya'],
            'text/html'                                                                 => ['html', 'file-code', 'Source Code'],
            'image/x-icon'                                                              => ['ico', 'file-image', 'Gambar'],
            'image/x-ico'                                                               => ['ico', 'file-image', 'Gambar'],
            'image/vnd.microsoft.icon'                                                  => ['ico', 'file-image', 'Gambar'],
            'text/calendar'                                                             => ['ics', 'file-alt', 'Lainnya'],
            'application/java-archive'                                                  => ['jar', 'file-alt', 'Lainnya'],
            'application/x-java-application'                                            => ['jar', 'file-alt', 'Lainnya'],
            'application/x-jar'                                                         => ['jar', 'file-alt', 'Lainnya'],
            'image/jp2'                                                                 => ['jp2', 'file-image', 'Gambar'],
            'video/mj2'                                                                 => ['jp2', 'file-video', 'Video'],
            'image/jpx'                                                                 => ['jp2', 'file-image', 'Gambar'],
            'image/jpm'                                                                 => ['jp2', 'file-image', 'Gambar'],
            'image/jpeg'                                                                => ['jpeg', 'file-image', 'Gambar'],
            'image/pjpeg'                                                               => ['jpeg', 'file-image', 'Gambar'],
            'application/x-javascript'                                                  => ['js', 'file-code', 'Source Code'],
            'application/json'                                                          => ['json', 'file-alt', 'Lainnya'],
            'text/json'                                                                 => ['json', 'file-alt', 'Lainnya'],
            'application/vnd.google-earth.kml+xml'                                      => ['kml', 'file-alt', 'Lainnya'],
            'application/vnd.google-earth.kmz'                                          => ['kmz', 'file-alt', 'Lainnya'],
            'text/x-log'                                                                => ['log', 'file-alt', 'Lainnya'],
            'audio/x-m4a'                                                               => ['m4a', 'file-audio', 'Audio'],
            'audio/mp4'                                                                 => ['m4a', 'file-audio', 'Audio'],
            'application/vnd.mpegurl'                                                   => ['m4u', 'file-alt', 'Lainnya'],
            'audio/midi'                                                                => ['mid', 'file-audio', 'Audio'],
            'application/vnd.mif'                                                       => ['mif', 'file-alt', 'Lainnya'],
            'video/quicktime'                                                           => ['mov', 'file-video', 'Video'],
            'video/x-sgi-movie'                                                         => ['movie', 'file-video', 'Video'],
            'audio/mpeg'                                                                => ['mp3', 'file-audio', 'Audio'],
            'audio/mpg'                                                                 => ['mp3', 'file-audio', 'Audio'],
            'audio/mpeg3'                                                               => ['mp3', 'file-audio', 'Audio'],
            'audio/mp3'                                                                 => ['mp3', 'file-audio', 'Audio'],
            'video/mp4'                                                                 => ['mp4', 'file-video', 'Video'],
            'video/mpeg'                                                                => ['mpeg', 'file-video', 'Video'],
            'application/oda'                                                           => ['oda', 'file-alt', 'Lainnya'],
            'audio/ogg'                                                                 => ['ogg', 'file-audio', 'Audio'],
            'video/ogg'                                                                 => ['ogg', 'file-video', 'Video'],
            'application/ogg'                                                           => ['ogg', 'file-alt', 'Lainnya'],
            'application/x-pkcs10'                                                      => ['p10', 'file-alt', 'Lainnya'],
            'application/pkcs10'                                                        => ['p10', 'file-alt', 'Lainnya'],
            'application/x-pkcs12'                                                      => ['p12', 'file-alt', 'Lainnya'],
            'application/x-pkcs7-signature'                                             => ['p7a', 'file-alt', 'Lainnya'],
            'application/pkcs7-mime'                                                    => ['p7c', 'file-alt', 'Lainnya'],
            'application/x-pkcs7-mime'                                                  => ['p7c', 'file-alt', 'Lainnya'],
            'application/x-pkcs7-certreqresp'                                           => ['p7r', 'file-alt', 'Lainnya'],
            'application/pkcs7-signature'                                               => ['p7s', 'file-alt', 'Lainnya'],
            'application/pdf'                                                           => ['pdf', 'file-pdf', 'PDF'],
            'application/x-x509-user-cert'                                              => ['pem', 'file-alt', 'Lainnya'],
            'application/x-pem-file'                                                    => ['pem', 'file-alt', 'Lainnya'],
            'application/pgp'                                                           => ['pgp', 'file-alt', 'Lainnya'],
            'application/x-httpd-php'                                                   => ['php', 'file-code', 'Source Code'],
            'application/php'                                                           => ['php', 'file-code', 'Source Code'],
            'application/x-php'                                                         => ['php', 'file-code', 'Source Code'],
            'text/php'                                                                  => ['php', 'file-code', 'Source Code'],
            'text/x-php'                                                                => ['php', 'file-code', 'Source Code'],
            'application/x-httpd-php-source'                                            => ['php', 'file-code', 'Source Code'],
            'image/png'                                                                 => ['png', 'file-image', 'Gambar'],
            'image/x-png'                                                               => ['png', 'file-image', 'Gambar'],
            'application/powerpoint'                                                    => ['ppt', 'file-powerpoint', 'Power Point'],
            'application/vnd.ms-powerpoint'                                             => ['ppt', 'file-powerpoint', 'Power Point'],
            'application/vnd.ms-office'                                                 => ['ppt', 'file-powerpoint', 'Power Point'],
            'application/msword'                                                        => ['ppt', 'file-powerpoint', 'Power Point'],
            'application/vnd.openxmlformats-officedocument.presentationml.presentation' => ['pptx', 'file-powerpoint', 'Power Point'],
            'application/x-photoshop'                                                   => ['psd', 'file-alt', 'Lainnya'],
            'image/vnd.adobe.photoshop'                                                 => ['psd', 'file-alt', 'Lainnya'],
            'audio/x-realaudio'                                                         => ['ra', 'file-audio', 'Audio'],
            'audio/x-pn-realaudio'                                                      => ['ram', 'file-audio', 'Audio'],
            'application/x-rar'                                                         => ['rar', 'file-archive', 'Arsip'],
            'application/rar'                                                           => ['rar', 'file-archive', 'Arsip'],
            'application/x-rar-compressed'                                              => ['rar', 'file-archive', 'Arsip'],
            'application/octet-stream'                                                  => ['rar', 'file-archive', 'Arsip'],
            'audio/x-pn-realaudio-plugin'                                               => ['rpm', 'file-alt', 'Lainnya'],
            'application/x-pkcs7'                                                       => ['rsa', 'file-alt', 'Lainnya'],
            'text/rtf'                                                                  => ['rtf', 'file-alt', 'Lainnya'],
            'text/richtext'                                                             => ['rtx', 'file-alt', 'Lainnya'],
            'video/vnd.rn-realvideo'                                                    => ['rv', 'file-video', 'Video'],
            'application/x-stuffit'                                                     => ['sit', 'file-alt', 'Lainnya'],
            'application/smil'                                                          => ['smil', 'file-alt', 'Lainnya'],
            'text/srt'                                                                  => ['srt', 'file-alt', 'Lainnya'],
            'image/svg+xml'                                                             => ['svg', 'file-image', 'Gambar'],
            'application/x-shockwave-flash'                                             => ['swf', 'file-alt', 'Lainnya'],
            'application/x-tar'                                                         => ['tar', 'file-archive', 'Arsip'],
            'application/x-gzip-compressed'                                             => ['tgz', 'file-archive', 'Arsip'],
            'image/tiff'                                                                => ['tiff', 'file-alt', 'Lainnya'],
            'text/plain'                                                                => ['txt', 'file-alt', 'Lainnya'],
            'text/x-vcard'                                                              => ['vcf', 'file-alt', 'Lainnya'],
            'application/videolan'                                                      => ['vlc', 'file-alt', 'Lainnya'],
            'text/vtt'                                                                  => ['vtt', 'file-alt', 'Lainnya'],
            'audio/x-wav'                                                               => ['wav', 'file-audio', 'Audio'],
            'audio/wave'                                                                => ['wav', 'file-audio', 'Audio'],
            'audio/wav'                                                                 => ['wav', 'file-audio', 'Audio'],
            'application/wbxml'                                                         => ['wbxml', 'file-alt', 'Lainnya'],
            'video/webm'                                                                => ['webm', 'file-video', 'Video'],
            'image/webp'                                                                => ['webp', 'file-image', 'Gambar'],
            'audio/x-ms-wma'                                                            => ['wma', 'file-audio', 'Audio'],
            'application/wmlc'                                                          => ['wmlc', 'file-alt', 'Lainnya'],
            'video/x-ms-wmv'                                                            => ['wmv', 'file-video', 'Video'],
            'video/x-ms-asf'                                                            => ['wmv', 'file-video', 'Video'],
            'application/xhtml+xml'                                                     => ['xhtml', 'file-code', 'Source Code'],
            'application/excel'                                                         => ['xl', 'file-excel', 'Spreadsheet'],
            'application/msexcel'                                                       => ['xls', 'file-excel', 'Spreadsheet'],
            'application/x-msexcel'                                                     => ['xls', 'file-excel', 'Spreadsheet'],
            'application/x-ms-excel'                                                    => ['xls', 'file-excel', 'Spreadsheet'],
            'application/x-excel'                                                       => ['xls', 'file-excel', 'Spreadsheet'],
            'application/x-dos_ms_excel'                                                => ['xls', 'file-excel', 'Spreadsheet'],
            'application/xls'                                                           => ['xls', 'file-excel', 'Spreadsheet'],
            'application/x-xls'                                                         => ['xls', 'file-excel', 'Spreadsheet'],
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'         => ['xlsx', 'file-excel', 'Spreadsheet'],
            'application/vnd.ms-excel'                                                  => ['xlsx', 'file-excel', 'Spreadsheet'],
            'application/xml'                                                           => ['xml', 'file-alt', 'Lainnya'],
            'text/xml'                                                                  => ['xml', 'file-alt', 'Lainnya'],
            'text/xsl'                                                                  => ['xsl', 'file-alt', 'Lainnya'],
            'application/xspf+xml'                                                      => ['xspf', 'file-alt', 'Lainnya'],
            'application/x-compress'                                                    => ['z', 'file-archive', 'Arsip'],
            'application/x-zip'                                                         => ['zip', 'file-archive', 'Arsip'],
            'application/zip'                                                           => ['zip', 'file-archive', 'Arsip'],
            'application/x-zip-compressed'                                              => ['zip', 'file-archive', 'Arsip'],
            'application/s-compressed'                                                  => ['zip', 'file-archive', 'Arsip'],
            'multipart/x-zip'                                                           => ['zip', 'file-archive', 'Arsip'],
            'text/x-scriptzsh'                                                          => ['zsh', 'file-alt', 'Lainnya'],
        ];

        return isset($mime_map[$mime]) ? $mime_map[$mime] : false;
    }
}