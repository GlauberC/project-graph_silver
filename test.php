<?php
    $COMMAND = "red generateDot(['d_0, 'd_1, 'u_0_L, 'u_0_R, 'u_1_L, 'u_1_R]{'P_1} | ({'F_1} | ({'P_0} | {'F_0}))  , ('F_0 =d= tau \ 'u_0_R . tau \ 'd_0 . {'F_0} + 'u_0_L \ tau . 'd_0 \ tau . {'F_0}, 'F_1 =d= tau \ 'u_1_R . tau \ 'd_1 . {'F_1} + 'u_1_L \ tau . 'd_1 \ tau . {'F_1}, 'P_0 =d= tau \ 'think_0 . {'P_0} + 'u_0_R \ 'u_1_L . {'eat_0}, 'P_1 =d= tau \ 'think_1 . {'P_1} + 'u_1_R \ 'u_0_L . {'eat_1}, 'eat_0 =d= tau \ 'eat_0 . {'release_0}, 'eat_1 =d= tau \ 'eat_1 . {'release_1}, 'release_0 =d= 'd_0 \ 'd_1 . {'P_0}, 'release_1 =d= 'd_1 \ 'd_0 . {'P_1})) .";
    //$COMMAND = "red generateDot('a \ 'b . { 'A } | 'c \ 'd .  { 'B}  , ('A =d= 'x \ 'y . { 'A} , 'B =d= 'w \ 'w . 't \ 't . { 'B} )) .";
    $DIR_MAUDE = "/usr/bin/maude";
    $DIR_FILE_MAUDE = "/home/glauberca/Documentos/Silver/semantics.maude";
    $MODF = "-no-banner";

    require_once ("maude-silver-run.php");
    testNodeAndLink($COMMAND, $DIR_MAUDE, $DIR_FILE_MAUDE, $MODF);

?>