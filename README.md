# autodeploy-github-bitbucket
A simple PHP script to auto-deploy from Github and Bitbucket, and executing a command like `composer install`

###Installation :

0. Very simple, download the `deploy.php` file and put it in the root of your code directory. If you're working with **Bitbucket**, uncomment line 12 and comment line 9.
0. Create a new repo on **Github** or **Bitbucket**, and push all your of code.
0. Add your server's SSH key to **Github** or **Bitbucket**.  

0. In your server, clone the repo from **Github** or **Bitbucket**, for example : `git clone git@github.com:user/repo.git`
0. Change the repository's owner on your server using : `chown -R your_user:www-data repo`. Note that you may have to `sudo` that command ;)
0. You may, also, have to check the permissions for subdirectories and files: _files => 644, folders => 755_.
0. Add a hook to **Github** or **Bitbucket**  :
  * **Github** : goto `https://github.com/user/repo/settings/hooks/new`, in _"Payload URL"_, put the url to *deploy.php* from your server click on _"Add webhook"_ button  
  ![alt text](http://i.imgur.com/9eOL0qp.png)
  * **Bitbucket**: goto https://bitbucket.org/user/repo/admin/hooks, select _"POST"_ option in the select box, click on _"Add hook"_, parte your URL to deploy.php file and click on _"save"_  
![alt text](http://i.imgur.com/ePCZBkp.png )  

0. That's all! For the first time, you should check that the `git pull` command is working. Echo the command `sudo -u www-data git pull`. If you get some errors like `error: cannot open .git/FETCH_HEAD: Permission denied` you should check the permissions for the repository's _".git"_ folder.  
You will also, if you're doing this for the first time, be prompted add Github or Bitbucket to your `~/.ssh/known_hosts` file, like this :  
![alt text](http://i.imgur.com/RHLLHbe.png )  

When you commit and you push automatically to **Github** or **Bitbucket**, it'll send a post request to `http://www.yourwebsite.com/deploy.php`, and this will execute a `git pull`


---
Note: _In **Step 3** I had a problem with SSH key when I added the default SSH key, so if you have the same problem, you have to generate a SSH key for www-data using : `sudo -u www-data ssh-keygen -t rsa` and then add it to your account._  
_For github, goto : https://github.com/user/repo/settings/keys, click on "Add deploy key"._  
_For Bitbucket, goto : https://bitbucket.org/user/repo/admin/deploy-keys, click on "Add key" button._

---


###For Laravel users
To avoid route exception you need to disable Laravel routing for the webhook route/url :

1. open public/.htaccess


2. add before the redirect trailing slashes rule

```
#Exclude directory deploy from rewriting eg "http://your_url/deploy.php"
RewriteRule ^(deploy.php) - [L]
```

###How to execute a command after the  `git pull` ?
Very simple, in your commit message put the command between a "[ ]". For example : `git commit -m "first commit [composer install]"`, when the server (*deploy.php*) detects the "[ ]" symbol, it extracts the text between them, and executes the included command, ex : `composer install`.




###More things:
- You can change the "[ ]" with other symbols, to do so, goto line 15 and change the '[' and ']' with the symbol you want to use, for example if you want to use "{ }" instead of the default one, the pattern will be `$pattern = '/\{(.*?)\}/';`.
- You can secure your POST request using a key in the hook. For example add a key like `http://www.yourwebsite.com/deploy.php?key=123456` and the *deploy.php* file will check for the `key` variable. But sure, you can imagine other methods.
- This solution is inspired from [@jondavidjohn's](https://twitter.com/jondavidjohn) article [Git pull from a php script, not so simple.](http://jondavidjohn.com/git-pull-from-a-php-script-not-so-simple)
- If you have any problem or contribution do not hesitate.
- Make sure to report any issues [here](https://github.com/kossa/autodeploy-github-bitbucket/issues) ;)
