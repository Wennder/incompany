<?php
header("Content-Type: text/Calendar");
header("Content-Disposition: inline; filename=calendar.ics");
echo "BEGIN:VCALENDAR\n";//Inicio Calendário
echo "VERSION:2.0\n";//Versão
echo "PRODID:-//Foobar Corporation//NONSGML Foobar//EN\n";
echo "METHOD:REQUEST\n"; // requerido pelo Outlook
/*Repete para cada evento*/
echo "BEGIN:VEVENT\n";//Inicio do Evento
echo "UID:".date('Ymd').'T'.date('His')."-".rand()."-example.com\n"; // required by Outlok
echo "DTSTAMP:".date('Ymd').'T'.date('His')."\n"; // required by Outlook
echo "DTSTART:20080413T000000\n";
echo "SUMMARY:TEST\n";
echo "DESCRIPTION: this is just a test\n"; // Descricao
echo "END:VEVENT\n";//Fim do evento
/*Fim repeticao*/
echo "END:VCALENDAR\n";//Fim calendário
?>