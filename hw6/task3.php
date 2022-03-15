<?php

abstract class Command {
    protected Application $application;
    protected Editor $editor;
    protected $backup;

    public function __construct (Application $application, Editor $editor) {
        $this->application = $application;
        $this->editor = $editor;
    }

    public function saveBackup() {
        $this->backup = $this->editor->getText();
    }

    public function undo() {
        $this->editor->setText($this->backup);
    }

    abstract public function execute($start = null, $end = null);
}

class CopyCommand extends Command {
    public function execute($start = null, $end = null) {
        $this->application->setClipboard($this->editor->getSelection($start, $end));
        return false;
    }
}

class CutCommand extends Command {
    public function execute($start = null, $end = null) {
        $this->saveBackup();
        $this->application->setClipboard($this->editor->getSelection($start, $end));
        $this->editor->deleteSelection($start, $end);
        return true;
    }
}

class PasteCommand extends Command {
    public function execute($start = null, $end = null) {
        $this->saveBackup();
        $this->editor->replaceSelection($this->application->getClipboard(), $start, $end);
        return true;
    }
}

class UndoCommand extends Command {
    public function execute($start = null, $end = null) {
        $this->application->undo();
        return false;
    }
}

class CommandHistory {
    protected array $history;

    public function push(Command $command) {
        $this->history[] = $command;
    }

    public function pop(): Command {
        return array_pop($this->history);
    }
}

class Editor {
    protected string $text;

    public function setText($text) {
        $this->text = $text;
    }

    public function getText() {
        return $this->text;
    }

    public function getSelection($start, $end) {
        return substr($this->text, $start, $end-$start);
    }

    public function deleteSelection($start, $end) {
        $this->text = substr($this->text, 0, $start).substr($this->text, $end, strlen($this->text) - $end);
    }

    public function replaceSelection($text, $start, $end) {
        $this->text = substr($this->text, 0, $start).$text.substr($this->text, $end, strlen($this->text) - $end);
    }
}

class Application {
    protected string $clipboard;
    protected array $editors;
    protected Editor $activeEditor;
    protected CommandHistory $history;

    public function __construct() {
        $this->history = new CommandHistory;
    }

    public function executeCommand(Command $command, $start, $end) {
        if ($command->execute($start, $end)) $this->history->push($command);
    }

    public function undo() {
        $command = $this->history->pop();
        if ($command)
            $command->undo();
    }

    public function getClipboard(){
        return $this->clipboard;
    }

    public function setClipboard(string $text){
        $this->clipboard = $text;
    }
}

$editor = new Editor;
$editor->setText("Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Consequat id porta nibh venenatis. Lacus vel facilisis volutpat est velit egestas dui id. In fermentum posuere urna nec tincidunt praesent semper feugiat nibh. Tristique sollicitudin nibh sit amet. Tristique et egestas quis ipsum. Arcu dictum varius duis at consectetur lorem donec massa sapien. Risus nec feugiat in fermentum posuere urna. Pharetra massa massa ultricies mi. Tincidunt augue interdum velit euismod in pellentesque massa. Enim nunc faucibus a pellentesque sit amet porttitor eget dolor. Neque gravida in fermentum et sollicitudin. Quis imperdiet massa tincidunt nunc pulvinar sapien et ligula ullamcorper. Risus feugiat in ante metus dictum at.");
echo "Source text: <br>";
echo $editor->getText();
$app = new Application;
$copy = new CopyCommand($app, $editor);
$cut = new CutCommand($app, $editor);
$paste = new PasteCommand($app, $editor);
$app->executeCommand($cut, 35, 55);
echo "<br>";
echo "Cutting symbols from 35 to 55<br>";
echo $editor->getText()."<br>";
echo "Undoing cut ...<br>";
$app->undo();
echo $editor->getText();