const {spawn} = require( 'child_process' );
const platform = require( 'os' ).platform();
const cmd = /^win/.test( platform )
	? `${process.cwd()}\\vendor\\bin\\phpunit.bat`
	: `${process.cwd()}/vendor/bin/phpunit`;

spawn( cmd, [], {stdio: 'inherit'} ).on( 'exit', code => process.exit( code ) );