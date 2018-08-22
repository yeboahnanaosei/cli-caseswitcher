# Command line version of [CaseSwitcher](https://github.com/yeboahnanaosei/caseswitcher)

CaseSwitcher let's you change filenames to either UPPERCASE or lowercase. It takes a directory and changes the filename of its content to the case you specify.



### This is the use case from  [CaseSwitcher](https://github.com/yeboahnanaosei/caseswitcher)

> Consider the situation where you (using a UNIX system - Linux/Mac) and a friend on a Windows system sends you an project to work on. You open the folder and you realize that all the files are in uppercase or title case. However, within the code, all files were referenced in lowercase. This is not a problem on Windows with Windows being case-insensitive with file names. This can however be problematic because the UNIX file system is case sensitive. This will mean that you will have to carefully change the file names to lowercase for your system. In such a situation, **CaseSwitcher** is your best friend.

##### How is this better than the `rename` utility on UNIX

With the `rename` utility you are forced to come up with a regular expression which can be unintuitive and daunting if you are not familiar with regular expressions. CaseSwitcher, I believe is more intuitive; all you need to do is just supply the path to the directory and the case you want to rename the files to.

Admittedly, the downside with CaseSwitcher is that you are forced to install PHP to use. But have no worries, there are plans to create a shell script to provide this same intuitive functionality.



### Requirements

You must have at least PHP Version: 7.0.25+ installed on your system



### How to install (UNIX)

CaseSwitcher is just a single PHP file called `caseswitcher`. You will need to do the following:

1. <b>Download this repo and extract the file.</b>

   Let's assume that you have downloaded and extracted the file into a directory called `Download` located here `/home/nana/Download`

2. <b>Make the file executable</b>

   To make the file executable, open your terminal and navigate to where you have extracted the file to like this:  `cd /home/nana/Download`

   Now type this to make the file executable:  `sudo chmod +x caseswitcher`

   Enter your password if prompted

3. <b>Now copy and place this file in a folder that is in your path</b>

   Read the following if you have no idea what your path is and how to carry out this third step:

   > **Knowing your path**
   >
   > Your path is just a 'list' of directories your operating system searches to find commands anytime you type a command on the terminal. This list shows directories separated by a colon `:` If you want to know which folders are in your path just type `echo $PATH` on your terminal. You should see something similar to this: `/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin:/usr/games`
   >
   > This path is showing 7 directories separated by a colon `:`  <br>
   >
   > We can list the directories as follows:
   >
   > 1. /usr/local/sbin
   > 2. /usr/local/bin
   > 3. /usr/sbin
   > 4. /usr/bin
   > 5. /sbin
   > 6. /bin
   > 7. /usr/games
   >
   > This means that anytime you type a command on your terminal the operating system will look through these directories to find the command. If the command is not found in any of the directories in your path, the system tells you that the command was not found.
   >
   >
   >
   > **Back to CaseSwitcher**
   >
   > To use CaseSwitcher just copy it from where you have it extracted to and place it in any of the folders you see in your path. You will need administrative rights to most of the directories in your path. 
   >
   > Let's assume you want to place it inside the `/usr/local/bin` directory and you have extracted CaseSwitcher to `/home/nana/Download`. Open your terminal and type the following command `sudo cp /home/nana/Download/caseswitcher /usr/local/bin/`. That's all! You now have CaseSwitcher in your path. You can now go ahead to use it.



4. <b>That's it. Just launch your terminal and start using CaseSwitcher</b>

### 

### How to use

Just open your terminal, call CaseSwitcher, supply the directory you want to change and the case you want to switch to. Just make sure the directory is writable. 

Like this: 

Say you want to change the contents of `/home/nana/project` to either lowercase or uppercase, just type:

 `caseswitcher -d /home/nana/project -l` or `caseswitcher -d /home/nana/project -u`

This means change the contents of the `project` directory to lowercase or to uppercase. 

If you want CaseSwitcher to recursively go through all sub-folders and change the filenames, then provide the `-r` option like this: `caseswitcher -d /home/nana/project -l -r` 

This means go through all sub-folders and change the filenames to lowercase.



You can join the options together without the need to separate them. Just make sure the `-d` is the last one you specify. This is because anytime caseswitcher sees the `-d` option, it expects what ever follows next to be a path to a directory.

eg. `caseswitcher -lrd /path/to/directory`.

This is exactly the same as `caseswitcher -d /path/to/directory -l -r`



<b>NOTE:</b> You cannot use both the `-l` and `-u` options together. That will not make sense.



### Options explained

|Option| Meaning | Example |
|----|----|----|
|-d [DIRECTORY]|Directory. This option is required and expects an argument<br>You supply the path to the directory whose contents you want to rename. The directory must exist, not empty and must be writable.| `caseswitcher -d path/to/directory` |
|-l | Lowercase. This option instructs caseswitcher to change all filenames to lowercase.  You cannot use this option together with `-u` option. | `caseswitcher -d path/to/directory -l` |
|-u | Uppercase. This option instructs caseswitcher to change all filenames to uppercase. You cannot use this option together with `-l` option. | `caseswitcher -d path/to/directory -u` |
|-r | Recursion. This instructs caseswitcher to recursively go through the directory and change the names  of all files and sub-folders to the specified case | `caseswitcher -d path/to/directory -l -u` |
|-h | Help. Displays a help message. Please note that supplying this option will make caseswitcher display the help message and exit even if you supplied any other option. | `caseswitcher -h` |
| |  |  |