<h1>The Manual</h1><br/>

This Manual aims to cover all the features of Literate. However, you do not need to read it if you don't want to.
syntax is pretty intuitive and you can figure it out on your own by experimenting with the compiler yourself.

<h2 id="basic-usage">Basic Usage</h2>
<p>Literate is a command line tool which you can use to generate either html, code, or both from a <code>.lit</code> file.
Once installed, you can use it by typing <code>lit file.lit</code>. There are four extra options you can provide:</p>
<ul>
    <li><code>--tangle  -t</code></li>
    <li><code>--weave   -w</code></li>
    <li><code>--out-dir -odir DIR</code></li>
    <li><code>--no-output</code></li>
    <li><code>--compiler</code></li>
</ul>
<p>With <code>--tangle</code> and <code>--weave</code> you can
specify if you would like only code (tangle) or only html (weave) to be generated. By default both code and html will be generated.</p>
<p><code>--no-output</code> tells Literate not to create any files, it will only give you errors.</p>
<p><code>--out-dir=dir</code> can be used to specify where you want Literate to put the output files.</p>
<p><code>--compiler</code> tells Literate not to ignore the <code>@compiler</code> command, which is used to report errors from the compiler of your language. You can read more about that in the <a href="#compiler-errors">compiler errors</a> section.

<hr>

<h2 id="example-program">An Example Program</h2>

We'll start out with an example that is fairly simple but shows
the important features of Literate.

<pre>
@code_type c .c
@comment_type // %s

@title Hello World

@s Introduction
This is a simple `Hello World` program written in C.

--- hello_world.c
#include &lt;stdio.h&gt;

int main() {
    @{Print "hello world"}

    return 0;
}
---

@s

Here we use the `printf` function from stdio to print.

--- Print "hello world"
printf("Hello world");
---

We should also make sure to add a newline.

--- Print "hello world" +=
printf("\n");
---
</pre>

You can read the explanation that follows, or run it on your own machine
and understand it on your own. This program is the hello_world.lit program in
the examples directory.

<hr>

<h2 id="start-of-program">The Start of the Program</h2>
<p>A Literate program will generally begin with 3 statements, although they are all optional. First you should set the code and comment type.
<p>To set the code type use
<code>@code_type type .extension</code>. This tells Literate what language you will be using. I use <code>c</code> and <code>.c</code> in the example, but for javascript it would be <code>javascript</code> and <code>.js</code>.</p>
<p>Next we want to define the comment type using <code>// %s</code>. For a multiline comment we could use <code>/* %s */</code>.</p>
<p>Now we give our program a title. To do that use the <code>@title</code> command.</p>

<hr>

<h2 id="adding-sections">Adding sections</h2>
<p>A Literate program consists of multiple sections, each beginning with the <code>@s title?</code> command. Sections may have a title, but it is not required. 
A section consists of explanation and code. Generally you provide some prose, followed by a piece of code, but really, you can do it in any order you like,
with any amounts of prose and code blocks.</p>

<hr>

<h2 id="prose">Using Markdown</h2>
<p>When writing prose, you may use Markdown and it will be converted to HTML on compilation. So using <code>**word**</code> will make <b>word</b> bold etc...
You can read a nice description of basic markdown <a href="https://help.github.com/articles/markdown-basics/">here</a> (note that <code>```</code> for 
denoting large code blocks will not work, just use a Literate code block).</p>
<p>The markdown used by Literate is slightly different than normal markdown: underscores do not do anything, and you can directly inline
html. If you have to write <code>&lt;</code> and <code>&lt;</code>, you can use <code>\&lt;</code> or <code>&amplt;</code> and the
equivalent for greater than.</p>

<p>Another possible command you can use while writing prose is the <code>@{codeblock name}</code> command. If you write this in
prose, Literate will replace this with a reference to the code block name and a link to the section the code block is in.</p>

<hr>

<h2 id="math">Writing Math Equations</h2>

<p>Literate supports rendering math equations. It uses the <a href="https://khan.github.io/KaTeX/">KaTeX</a> library to render LaTeX
equations. Just put the equation between <code>$</code>. If you want the equation to be block level (take up an entire row), use
<code>$$</code>. If you are using inline equations, make sure that there are no newlines in your equation</p>

<p>Note that if you are viewing the html files offline, the math will still render, but the fonts won't be as nice. If you wish
to save the html file with good fonts, you can make a pdf.</p>

<hr>

<h2 id="code-blocks">Code blocks</h2>
<p>To create a code block, you use three dashes, followed by the code block name, and another three dashes to signal the end of the code block. For example:</p>
<pre>
--- Code block
some code here
---
</pre>
<p>A code block may have any name but it must not have any trailing whitespace. In addition, if you name a code block a filename (e.g. <code>file.c</code>),
this code block will be top-level, and when compiling the Literate file, all the code from this code block will be put in that file.</p>

<p>If you add a <code>+=</code> after the code block name, the code will be added to that block (the block must already be defined somewhere else).
This is useful because sometimes you want to add a piece of code a code block, but it only makes sense to add it later after the definition.
For example, if you have a code block for all the constants in your program, you can add them as you use them instead of adding them all at once
at the top of the program as you would in a standard programming setting.</p>

<p>The most useful command in a code block is the <code>@{codeblock name}</code>. Just like it does in prose, it will reference and link the code block
name that you use. However, when generating code from the Literate file, the code that is contained in <code>codeblock name</code> will be inserted at this position
in the generated source.</p>

<hr>

<h2 id="css-customization">Customizing HTML output with CSS</h2>

<p>You may not like what the HTML output from Literate looks like by default. In that case, fear not, you can customize
every bit of the page with CSS (after all, it is just HTML). There are three different kinds of customizations you can make:</p>
<ul>
    <li>You can completely overwrite the default CSS with your own</li>
    <li>You can add your own CSS to the default CSS</li>
    <li>You can overwrite the syntax highlighting theme</li>
</ul>

<p>You can make each of these customizations with a separate command, and each
takes the CSS file which contains your changes:</p>

<ul>
    <li><code>@overwrite_css file.css</code></li>
    <li><code>@add_css file.css</code></li>
    <li><code>@colorscheme file.css</code></li>
</ul>

<p>You can find some nice colorschemes 
<a href="http://jmblog.github.io/color-themes-for-google-code-prettify/">here</a>. The default colorscheme is Tomorrow Light.</p>

<hr>

<h2 id="pdf">Saving the HTML as a PDF</h2>

The HTML file should look the same on any computer, even when used offline (except for the math fonts which won't look as nice). Even so,
if you want to save the HTML file for offline use, or for another reason, you can use your browser's "print to pdf" option. I think Chrome's
PDF printer performs the best. Go to <code>file -&gt; print</code>. Change the destination to "Save as PDF", and under "More settings" make sure you have
"Background graphics" selected.

<hr>

<h2 id="change-files">Change Files</h2>

<p>First, note that <code>@include &lt;file.lit&gt;</code> will include another literate file, as if you had written
the contents of the included file in the current file.<p>

<p>The <code>@change</code> command is very similar, except that some changes are performed on the other file when it is included.</p>
<p>Here is an example of the syntax:</p>

<pre>
@change examples/wc.lit

This is an example of using the @change command to recreate change files.

We are going to change the title in wc.lit from WC to Word Count.

@replace
@title WC
@with
@title Word Count
@end

Let's also change the comment_type from // %s to /* %s */.

@replace
@comment_type // %s
@with
@comment_type /* %s */
@end

@change_end
</pre>

<p>You can make as many changes as you want between the <code>@change</code> and <code>@change_end</code> commands.

<p>You should see that the title was changed to Word Count and if you
view the code, It should be commented mostly with /* ... */.</p>

<hr>

<h2 id="compiler-errors">Reporting compiler errors to the correct line</h2>

<p>It would be nice if when compiling the generated code file, if the program has errors,
for the compiler to report the error to the correct line in the lit file. To do this,
you will tell which command Literate should use to run the compiler, and Literate
will check with the compiler when generating the code file.</p>

To use this feature, you should use the <code>@compiler &lt;sh-command&gt;</code> command.

In addition you must compile with the <code>--compiler</code> flag (otherwise Literate
will ignore the command).

The <code>sh-command</code> should invoke literate itself because using <code>--compiler</code>
turns off output generation. This is because on larger projects you probably have your own build
mechanism and don't want little code and html files being generated whenever you lint.

As an example, to check for errors in the hello_world.c file, you could put the following in the file:

<pre>
@compiler lit hello_world.lit && clang hello_world.c
</pre>

On a larger project you might just have

<pre>
@compiler make
</pre>

which will build using Literate and then compile the resulting files. You can see this in the source code
for literate.

<p>When the lit file is compiled, this command will be run, and the error output (if any) will be parsed
and changed to report the corresponding line numbers in the lit file. Literate can parse clang, because clang
is a common compiler. If the compiler you are using is not supported, you can provide an <code>error_format</code>
that will be used to parse the compiler output. The supported compilers are:</p>

<ul>
    <li>clang (C, C++)</li>
    <li>gcc (C)</li>
    <li>g++ (C++)</li>
    <li>javac (Java)</li>
    <li>pyflakes (Python)</li>
    <li>jshint (Javascript)</li>
    <li>dmd (D)</li>
</ul>

<p>For example, the to define the error_format for <code>clang</code>
you would add this line to your file:</p>

<pre>
@error_format %s:%l:%s:%s: %m
</pre>

There are several special characters here:
<ul>
    <li><code>%s</code> means any string of characters that should be ignored</li>
    <li><code>%l</code> means the line number</li>
    <li><code>%m</code> means the error message</li>
</ul>

<hr>

<h2 id="vim-plugin">Using the Vim plugin</h2>

<p>Literate also comes with a Vim plugin to make writing Lit files much easier. You can download it <a href="https://github.com/zyedidia/literate.vim">here</a>.
The plugin provides all sorts of niceties like syntax highlighting (it correctly syntax highlights the language embedded in code blocks using information
from the @code_type), and keybindings to let you jump between code blocks.</p>

<p>When you first open a <code>.lit</code> file, vim will syntax highlight commands like @code_type, and @title... correctly, but it will
not syntax highlight the embedded code blocks right away. This is because when you opened the empty file, there was no @code_type, so
vim was unable to know what language you are using. You can execute <code>:e</code> to reload the syntax highlighting (make sure the file is saved).</p>

<p>You can use <code>&lt;C-]&gt;</code> to jump to a code block definition from a code block use. If your cursor is on <code>@{block name}</code> and you press <code>&lt;C-]&gt;</code>,
your cursor will jump to the next use/definition.</p>

<hr>

<h2 id="command-index">Index of all Commands</h2>

<code>@code_type lang-name .lang-ext</code><br/>
<code>lang-name</code>: The name of the language you are using<br/>
<code>lang-ext</code>: The extension of the language you are using. For Python this would be <code>py</code>.<br/>
The <code>code_type</code> command is used for knowing which language you are using. This information is used when creating an index,
and for syntax highlighting with the Vim plugin.<br/><br/>

<code>@comment_type /* %s */</code><br>
This command tells Literate what the syntax is for comments. Literate automatically adds comments with the section names to the generated code.
The above example would be for a language like C.<br><br>

<code>@title title</code><br>
Sets the title for the page.<br><br>

<code>@s title?</code><br>
This command creates a new section. The <code>title</code> argument is optional.<br><br>

<code>$equation$</code><br>
Renders <code>equation</code> as TeX by using MathJax. Use <code>$$equation$$</code> to make the equation a block element (takes up an entire line).<br><br>

<code>@{code block name}</code><br>
When used in prose, this creates a link to <code>code block name</code>.<br>
When used in a code block. This also links to the code block name, but when tangling, the code from that code block, will be inserted at this position.<br><br>

<code>Code blocks</code>
<pre>
--- Block name
code...
---
</pre>
Creates a code block named Block name. If you add <code>+=</code> to the end of the name, Literate will append the code in the code block to an existing
block named Block name.<br><br>

<code>@include &lt;file&gt;</code><br>
If the file is a lit file, the lit file will be included as if you had written everything contained in the lit file
in the current file.<br><br>

<code>@change</code>
<pre>
@change &lt;file&gt;

Comments here

@replace
Some code
@with
Some other code
@end

More comments

...

@change_end
</pre>

This is the syntax for a change command. This will include <code>&lt;file&gt;</code>, but will the changes given. The
code between <code>@replace</code> and <code>@with</code> will be replaced with <code>@with</code> and <code>@end</code>.<br>
You can have as many of these <code>@replace ... @with .. @end</code> statements in a change statement as you want.<br><br>

<code>@add_css file.css</code><br>
This will take the css contained in <code>file.css</code> and add it to the
default css that Literate uses.<br><br>

<code>@overwrite_css file.css</code><br>
This will overwrite Literate's default CSS with the CSS contained in <code>
file.css</code>.<br><br>

<code>@colorscheme file.css</code><br>
This will replace the default colorscheme (Tomorrow Light) will the css in <code>file.css</code>.
<p>You can find some nice colorschemes 
<a href="http://jmblog.github.io/color-themes-for-google-code-prettify/">here</a>.<br><br>

<code>@compiler &lt;sh-command&gt;</code><br>
Defines the command that will be run to check for errors from the language compiler.
See <a href="#compiler-errors">this section</a>.<br><br>

<code>@error_format format</code><br>
If your compiler is not supported, you can provide an error format string to
define how Literate should parse the compiler command's output.