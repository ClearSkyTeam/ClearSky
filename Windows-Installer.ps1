Add-Type -AssemblyName System.IO.Compression.FileSystem
$WC = New-Object System.Net.WebClient
'================================================================='
'|     Welcome to ClearSky install script for Windows            |'
'| We strong suggest you use Linux instead of Microsoft Windows  |'
'================================================================='
sleep 1
Try{
'Fetching latest ClearSky phar...'
[xml]$jenkinsinfo = $WC.DownloadString("http://jenkins.clearskyteam.org/job/ClearSky/api/xml")
$buildnumber = $jenkinsinfo.freeStyleProject.lastSuccessfulBuild.number
"Latest successful build number is #$buildnumber"
'Downloading Clearsky...'
$WC.DownloadFile("http://jenkins.clearskyteam.org/job/ClearSky/$buildnumber/artifact/releases/ClearSky-master-%23$buildnumber.phar",".\ClearSky.phar")
'Done!'
'Downloading PHP runtime...'
$WC.DownloadFile("https://github.com/ClearSkyTeam/PHPbinary/blob/master/PHP5-windows-x86.zip?raw=true",".\php.zip")
'Extracting...'
[System.IO.Compression.ZipFile]::ExtractToDirectory(".\php.zip", ".\")
'Cleaning...'
rm php.zip
'Done!'
'Downloading Startup Script'
$WC.DownloadFile("https://raw.githubusercontent.com/ClearSkyTeam/ClearSky/master/start.cmd",".\start.cmd")
}
Catch{
'Something went wronly , please restart this script later'
sleep 5
exit
}
'All have done! Run start.cmd for your new server!'
sleep 5
rm split-path -parent $MyInvocation.MyCommand.Definition
exit
