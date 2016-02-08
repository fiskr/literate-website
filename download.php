<!-- download.php -->
<!DOCTYPE html>
<html>
    <head>
        <title>Download Literate</title>

        <!-- Include the head to bring in jquery, bootstrap and custom CSS -->
        <?php include 'includes/head.php';?>

        <!-- Small javascript to download the zip -->
        <script>
        function download() {
            window.open("https://github.com/zyedidia/Literate/archive/master.zip", "_self");
        }
        </script>


        <?php include 'includes/google_analytics.php'?>
    </head>

    <body>
        <!-- Include the top navigation bar -->
        <?php include 'includes/navigation.php';?>

        <div class="container">
            <!-- Main download button -->
            <div style="text-align: center">
                <button class="btn btn-primary btn-lg" onclick="download()">Download</button>
            </div>

<!-- Installation instructions -->
<h2>Installation</h2>
You can view or clone the <a href="https://github.com/zyedidia/Literate" target="_blank">github repository</a>.<br>
Installation is quite simple.<br/>
<hr>

<h3>Mac</h3>

<p>On Mac you can use brew to install Literate:</p>
<pre>
$ brew tap zyedidia/literate
$ brew install --HEAD literate
</pre>
<p>For now, Literate is head only.</p>

<h3>Building from source</h3>
<p>Literate is made with the <a href="http://dlang.org">D programming language</a> so you must
install <a href="dlang.org/download.html">dmd</a> (D compiler) and <a href="https://code.dlang.org/download">dub</a> (D package manager).

Then you should download the zip or clone the repository and run the following commands:

<pre>
$ cd Literate
$ make
</pre>

You can find the binary in <code>path/to/Literate/bin</code> (you may want to add this
to your path).

            <!-- Installing the Vim plugin -->
            <h2>Vim Plugin</h2>
            In addition, there is also a vim plugin which adds syntax highlighting. You can get it <a href="https://github.com/zyedidia/literate.vim">here</a>.
            
            I recommend you install it with Pathogen or Vundle or whichever plugin manager you use.
            See the <a href="manual.php#vim-plugin">manual</a> for some extra tips on making Literate work even better with Vim.

        </div>
    </body>
</html>

