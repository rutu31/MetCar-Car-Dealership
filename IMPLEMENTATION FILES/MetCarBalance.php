{\rtf1\ansi\ansicpg1252\cocoartf1038\cocoasubrtf250
{\fonttbl\f0\fnil\fcharset0 Monaco;}
{\colortbl;\red255\green255\blue255;\red0\green128\blue128;\red63\green127\blue127;\red128\green128\blue128;
\red63\green127\blue95;\red63\green95\blue191;\red127\green0\blue127;\red42\green0\blue255;\red255\green0\blue0;
\red102\green0\blue0;\red0\green130\blue0;\red0\green0\blue255;}
\margl1440\margr1440\vieww22440\viewh12620\viewkind0
\deftab720
\pard\pardeftab720

\f0\fs22 \cf2 <!\cf3 DOCTYPE\cf0  \cf2 html\cf0  \cf4 PUBLIC\cf0  \cf2 "-//W3C//DTD XHTML 1.0 Transitional//EN"\cf0  \
 \cf5 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"\cf2 >\cf0 \
\
\pard\pardeftab720
\cf6 <!-- \cf0 \
\cf6 	THIS FILE ACCEPTS THE START DATE AND END DATE TO SHOW THE CASH COLLECTED BETWEEN THOSE DATES.\cf0 \
\cf6 -->\cf0  \
 \
\pard\pardeftab720
\cf2 <\cf3 html\cf0  \cf7 xmlns\cf0 =\cf8 "http://www.w3.org/1999/xhtml"\cf2 >\cf0 \
\cf2 <\cf3 head\cf2 >\cf0 	\
\cf2 <\cf3 title\cf2 >\cf0 MetCar Balance\cf2 </\cf3 title\cf2 >\cf0 \
	\cf2 <\cf3 link\cf0  \cf7 rel\cf0 =\cf8 "stylesheet"\cf0  \cf7 type\cf0 =\cf8 "text/css"\cf0  \cf7 href\cf0 =\cf8 "MetCarCSS.css"\cf0  \cf2 />\cf0 \
\
	\cf9 <?php\cf0  \
	\cf4 // CREATE DATABASE CONNECTION\cf0 \
	\
	\cf10 $db_conn \cf0 = @mysql_connect(\cf11 "localhost"\cf0 , \cf11 "root"\cf0 , \cf11 ""\cf0 );\
	\cf12 if\cf0 (! \cf10 $db_conn\cf0 ) \{\
		\cf12 echo \cf0 (\cf11 "Unable to connect to database."\cf0 );\
		\cf12 exit\cf0 ();\
	\}\
	\
	\cf10 $db \cf0 = @mysql_select_db(\cf11 "MetCar"\cf0 ,\cf10 $db_conn\cf0 );\
	\cf12 if\cf0 (!\cf10 $db\cf0 ) \{\
		\cf12 echo \cf0 (\cf11 "Unable to open tootie database"\cf0 );\
		\cf12 exit\cf0 ();\
	\} \
	\
\pard\pardeftab720
\cf9 ?>\cf0 \
		\
\pard\pardeftab720
\cf2 </\cf3 head\cf2 >\cf0 \
\
\cf2 <\cf3 body\cf2 >\cf0 \
\
	\cf2 <\cf3 div\cf0  \cf7 class\cf0 =\cf8 "main_menu_link"\cf2 >\cf0 \
		\cf2 <\cf3 a\cf0  \cf7 href\cf0 =\cf8 "MetCarHome.html"\cf2 >\cf0 Main menu\cf2 </\cf3 a\cf2 >\cf0 \
	\cf2 </\cf3 div\cf2 >\cf0 \
	\
	\cf6 <!-- FORM THAT ACCEPTS START DATE AND END DATE TO SHOW CASH COLLECTED BETWEEN THAT PERIOD -->\cf0 \
	\
	\cf2 <\cf3 form\cf0  \cf7 name\cf0 =\cf8 "shop_balance"\cf0  \cf7 method\cf0 =\cf8 "post"\cf0  \cf7 action\cf0 =\cf8 "MetCarShowBalance.php"\cf2 >\cf0 \
		\cf2 <\cf3 div\cf0  \cf7 class\cf0 =\cf8 "job_list"\cf2 >\cf0 \
		\cf2 <\cf3 fieldset\cf2 >\cf0 \
		\cf2 <\cf3 legend\cf2 ><\cf3 span\cf0  \cf7 style\cf0 =\cf8 "color: white"\cf2 >\cf0 Show Shop Balance\cf2 </\cf3 span\cf2 ></\cf3 legend\cf2 >\cf0 \
		\
			\cf2 <\cf3 br\cf0  \cf2 />\cf0 \
			\cf2 <\cf3 span\cf0  \cf7 style\cf0 =\cf8 "color: white"\cf2 >\cf0 Enter Start Date:  \cf2 </\cf3 span\cf2 ><\cf3 br\cf0  \cf2 /><\cf3 br\cf0  \cf2 />\cf0 \
			\cf8 &nbsp;&nbsp;\cf0 MM \cf2 <\cf3 input\cf0  \cf7 type\cf0 =\cf8 "text"\cf0  \cf7 name\cf0 =\cf8 "jobList_MM1"\cf0  \cf7 id\cf0 =\cf8 "jobList_MM1"\cf0  \cf2 />\cf0  \cf8 &nbsp;\cf0 \
			DD \cf2 <\cf3 input\cf0  \cf7 type\cf0 =\cf8 "text"\cf0  \cf7 name\cf0 =\cf8 "jobList_DD1"\cf0  \cf7 id\cf0 =\cf8 "jobList_DD1"\cf0  \cf2 />\cf0  \cf8 &nbsp;\cf0 \
			YYYY  \cf2 <\cf3 input\cf0  \cf7 type\cf0 =\cf8 "text"\cf0  \cf7 name\cf0 =\cf8 "jobList_YYYY1"\cf0  \cf7 id\cf0 =\cf8 "jobList_YYYY1"\cf0  \cf2 /><\cf3 br\cf0  \cf2 /><\cf3 br\cf0  \cf2 />\cf0 \
			\
			\cf2 <\cf3 span\cf0  \cf7 style\cf0 =\cf8 "color: white"\cf2 >\cf0 Enter End Date: \cf2 </\cf3 span\cf2 ><\cf3 br\cf0  \cf2 /><\cf3 br\cf0  \cf2 />\cf0 \
			\cf8 &nbsp;&nbsp;\cf0 MM \cf2 <\cf3 input\cf0  \cf7 type\cf0 =\cf8 "text"\cf0  \cf7 name\cf0 =\cf8 "jobList_MM2"\cf0  \cf7 id\cf0 =\cf8 "jobList_MM2"\cf0  \cf2 />\cf0  \cf8 &nbsp;\cf0 \
			DD \cf2 <\cf3 input\cf0  \cf7 type\cf0 =\cf8 "text"\cf0  \cf7 name\cf0 =\cf8 "jobList_DD2"\cf0  \cf7 id\cf0 =\cf8 "jobList_DD2"\cf0  \cf2 />\cf0  \cf8 &nbsp;\cf0 \
			YYYY  \cf2 <\cf3 input\cf0  \cf7 type\cf0 =\cf8 "text"\cf0  \cf7 name\cf0 =\cf8 "jobList_YYYY2"\cf0  \cf7 id\cf0 =\cf8 "jobList_YYYY2"\cf0  \cf2 /><\cf3 br\cf0  \cf2 /><\cf3 br\cf0  \cf2 />\cf0  			\
			\
			\cf2 <\cf3 div\cf0  \cf7 class\cf0 =\cf8 "submit_btn"\cf2 >\cf0 \
				\cf2 <\cf3 br\cf0  \cf2 /><\cf3 input\cf0  \cf7 type\cf0 =\cf8 "submit"\cf0  \cf7 value\cf0 =\cf8 "Show Balance"\cf0  \cf2 />\cf0 \
			\cf2 </\cf3 div\cf2 >\cf0 \
			\
		\cf2 </\cf3 fieldset\cf2 >\cf0 \
		\cf2 </\cf3 div\cf2 >\cf0 \
	\cf2 </\cf3 form\cf2 >\cf0 \
\
\pard\pardeftab720
\cf9 <?php\cf0  mysql_close(\cf10 $db_conn\cf0 );\cf9 ?>\cf0 \
\pard\pardeftab720
\cf2 </\cf3 body\cf2 >\cf0 \
\cf2 </\cf3 html\cf2 >\cf0 \
}