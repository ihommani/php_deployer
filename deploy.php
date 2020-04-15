<?php
namespace Deployer;

require 'recipe/common.php';

// Project name
set('application', 'api-resource-genres');

// Project repository
set('repository', 'git@github.com:ihommani/php_deployer.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true); 

// Shared files/dirs between deploys 
set('shared_files', []);
set('shared_dirs', []);

// Writable dirs by web server 
set('writable_dirs', []);


// Hosts

host('dev')
    ->hostname('web.dev.believe.fr')
    ->user('ismael.hommani')
    ->port(22)
    ->identityFile('~/.ssh/id_rsa')
    ->forwardAgent(true)
    ->multiplexing(true)
    ->addSshOption('UserKnownHostsFile', '/dev/null')
    ->addSshOption('StrictHostKeyChecking', 'no') 
    ->set('deploy_path', '~/dev/{{application}}');
    //->set('current_path', '~/dev/{{application}}/scripts@') // TODO: pb to over
    //->set('release_path', '~/dev/{{application}}/_scripts@');    

host('staging')
    ->hostname('web.dev.believe.fr')
    ->user('ismael.hommani')
    ->port(22)
    ->identityFile('~/.ssh/id_rsa')
    ->forwardAgent(true)
    ->multiplexing(true)
    ->addSshOption('UserKnownHostsFile', '/dev/null')
    ->addSshOption('StrictHostKeyChecking', 'no') 
    ->set('deploy_path', '~/staging/{{application}}');    



// Tasks
desc('Display hello world on the stdout');
task('test:1', function () {
    writeln('lorem ipsum1');
});
desc('Display hello world on the stdout');
task('test:2', function () {
    writeln('lorem ipsum2');
});
desc('Display hello world on the stdout');
task('test:3', function () {
    writeln('lorem ipsum3');
});
desc('Display hello world on the stdout');
task('test:4', function () {
    writeln('lorem ipsum4');
});

desc('Change name from current to scritps');
task('deploy:symlink_renaming', function () {
    run('cd {{deploy_path}} && mv current scripts');
});

desc('Big Test');
task('tests', [
    'test:1',
    'test:2',
    'test:3',
    'test:4']
);


desc('Deploy your project');
task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:writable',
    'deploy:vendors',
    'deploy:clear_paths',
    'deploy:symlink',
    'deploy:symlink_renaming',
    'deploy:unlock',
    'cleanup',
    'success'
]);

// [Optional] If deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');
