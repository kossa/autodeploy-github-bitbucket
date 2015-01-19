# autodeploy-github-bitbucket
A simple PHP script to auto deploy from github and bitbucket, and executing a command like "composer install"...

###Installation :

0. Very simple, Download `deploy.php` file and put it in the root of your code directory. If you're working with **Bitbucket**, uncomment line 12 and comment line 9.
0. Create a new repo on **Github** or **Bitbucket**, and push all your code.
0. In your server, clone the repo from **Github** or **Bitbucket**, for example : `git clone git@github.com:user/repo.git`
0. Change the chown of your repo on your server `chown -R your_user:www-data repo`, may you should use sudo ;)
0. Add a hook to **Github** or **Bitbucket**  
  * * **Github** * : goto `https://github.com/user/repo/settings/hooks/new`, in "Payload URL" put the url to *deploy.php* from your server click on "Add webhook" button ![alt text](http://i.imgur.com/9eOL0qp.png)
  * * **Bitbucket** *: goto https://bitbucket.org/user/repo/admin/hooks, select "POST" option in the select box, click on "Add hook", parte your URL to deploy.php file and click on "save"  
![alt text](http://i.imgur.com/ePCZBkp.png )  

0. That's all, when you commit and you push automatically **Github** or **Bitbucket** send a post request to `http://www.yourwebsite.com/deploy.php`, and this will execute a `git pull`


###How to execute a command after the  `git pull` ?
Very simple, in your commit message include the command into a [], for example : `git commit -m "first commit [composer install]"`, when the server (*deploy.php*) detect the [] symbol, it extracts the text between[], and execute the command, ex : `composer install`.


*Note: you can change the [] with an other symbol, to do it goto line 15 and change the '[' and ']' with the symbol you want to use, for example if you want to use {} instead [] the pattern will be* `$pattern = '/\{(.*?)\}/';`