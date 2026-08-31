<?php

/**
 * Renders a self-contained "this deployment is misconfigured" page.
 *
 * Plain PHP with no dependencies on purpose: it is used both before the
 * framework boots (api/index.php) and from the exception handler. It never
 * prints configuration values — only the names of the variables to check.
 *
 * @return callable(string, string, array<int, string>, string): string
 */
return function (string $heading, string $intro, array $steps, string $english): string {
    $esc = static fn (string $value): string => htmlspecialchars($value, ENT_QUOTES, 'UTF-8');

    $items = '';
    foreach ($steps as $step) {
        // Steps may contain <code> markup, so they are escaped by the caller.
        $items .= '      <li>'.$step."</li>\n";
    }

    return <<<HTML
<!doctype html>
<html lang="ar" dir="rtl">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex">
<title>{$esc($heading)}</title>
<style>
  body { margin:0; background:#0f1216; color:#e8e6e1; font-family:Tahoma,"Segoe UI",system-ui,sans-serif; line-height:1.9; }
  .box { max-width:640px; margin:8vh auto; padding:32px 28px; background:#181d23; border:1px solid #2a3138; border-radius:12px; }
  h1 { margin:0 0 6px; font-size:22px; }
  p  { color:#a6aeb8; margin:0 0 18px; }
  ol { padding-inline-start:20px; margin:0; }
  li { margin-bottom:10px; }
  code { direction:ltr; unicode-bidi:embed; background:#0f1216; border:1px solid #2a3138;
         border-radius:5px; padding:2px 7px; font-family:ui-monospace,Menlo,Consolas,monospace; font-size:13px; }
  .en { margin-top:22px; padding-top:16px; border-top:1px solid #2a3138; direction:ltr; text-align:left;
        color:#8f98a3; font-size:13px; }
</style>
</head>
<body>
  <div class="box">
    <h1>{$esc($heading)}</h1>
    <p>{$intro}</p>
    <ol>
{$items}    </ol>
    <div class="en">{$english}</div>
  </div>
</body>
</html>
HTML;
};
