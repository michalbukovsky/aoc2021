<?php declare(strict_types = 1);

error_reporting(E_ALL);

use App\IRunner;
use App\Utils\Outputter;
use Tracy\Debugger;

require_once __DIR__ . '/vendor/autoload.php';

$loader = new Nette\Loaders\RobotLoader;

$loader->addDirectory(__DIR__ . '/app');
Debugger::enable(null, __DIR__ . '/log');
Debugger::$strictMode = true;

$loader->setTempDirectory(__DIR__ . '/temp');
$loader->register();

$day = ($argv[1] ?? null);
$part = (int)($argv[2] ?? 1);

if ($day === null) {
    Outputter::errorFatal('No day specified');
}
if (!preg_match('~^\d{1,2}$~', $day)) {
    Outputter::errorFatal("Value '$day' is invalid for a day number.");
}

$folderName = __DIR__ . '/app/days/' . str_pad($day, 2, '0', STR_PAD_LEFT);
if (!file_exists($folderName)) {
    Outputter::errorFatal("Day '$day' not yet implemented");
}

$filesInFolder = scandir($folderName);

foreach ($filesInFolder as $filename) {
    if (substr($filename, -3) === 'php') {
        $className = '\\App\\' . substr($filename, 0, -4);

        if (!is_a($className, IRunner::class, true)) {
            continue;
        }

        /** @var IRunner $day */
        $day = new $className();

        Outputter::notice('Result:');
        Outputter::newline();

        try {
            $day->run($part);
        } catch (Throwable $e) {
            Outputter::error('Fatal error (' . get_class($e) . '):');
            Outputter::errorFatal($e->getMessage());
        }
        die;
    }
}

Outputter::errorFatal("No Runner class found for day '$day'");
