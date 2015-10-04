from BeautifulSoup import BeautifulSoup
import urllib2

thisurl = "http://bisniskeuangan.kompas.com/"
handle = urllib2.urlopen(thisurl)
html_doc =  handle.read()
handle.close()
print "Open the link " + thisurl + "..."
print "Read the sources..."

target = open("dataOri.html", 'w')
target.write(html_doc)
target.close()
print "Saved as dataOri.html successfully."

soup = BeautifulSoup(html_doc)

savelink = open("hyperlink.html", 'w')

data = 1

print "Start to filtering 'a' tag..."
for link in soup.findAll('a'):
	try :
		anotherlink =link.get('href')
		
		print "Get a hyperlink..."
		handlelink = urllib2.urlopen(anotherlink)
		html_doclink = handlelink.read()
		nameoffile = "data" + str(data) + ".html"
		targetlink = open(nameoffile, 'w')
		targetlink.write(html_doclink)
		targetlink.close()
		
		savelink.write(anotherlink)
		savelink.write("\n")
		print(anotherlink)
		handlelink.close()
		print "successfully saved as " + nameoffile
		
		data = data + 1
	except :
		continue

savelink.close()
