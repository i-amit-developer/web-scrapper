
# Scrap web data scraper using simplehtmldom

## Setup
- Download and extract files in your localhost.

### Documentation

- [simplehtmldom Docs](https://simplehtmldom.sourceforge.io/docs/1.9/index.html)

### Step 2 (Local File Setup)
- Create index.php where web-scrapper Installed

   ```php
   <?php
      // Specify your Identifier tag/Class/ID here
      foreach ($html_base->find('body *') as $key => $element) {
         $data[$key]['tag'] = $element->tag;
         $data[$key]['content'] = $element->plaintext;

         // Get Name, Phone, Address, Website from a specific listing 
         if ($tagName == 'p') {
            $title 		= $element->find('strong', 0)->plaintext;
   
            $displayAddr[] = $element->outertext;
            $addr 		= $element->outertext;
            $addrExplode = array_reverse(array_filter(explode('<br>', $addr)));
   
            $website = str_get_html($addrExplode[1]);
            $websiteAddr = '';
            if($website){
               $websiteAddr = @$website->find("a", 0)->href;
            }
   
            $phone = @$addrExplode[2];
            $addrs = @$addrExplode[3];
   
            if ($websiteAddr == null) {
               $phone = $addrExplode[1];
               $addrs = $addrExplode[2];
            }
   
            if (!isset($addrExplode[3])) {
               $phone = '';
               $addrs = $addrExplode[1];
            }
   
            $blogdata[$key]["Name"] = $title;
            $blogdata[$key]["Phone"] = strip_tags($phone);
            $blogdata[$key]["Address"] = strip_tags($addrs);
            $blogdata[$key]["Website"] = $websiteAddr;
         } else {
            $blogdata[$key]["Name"] = $element->plaintext;
            $blogdata[$key]["Phone"] = '';
            $blogdata[$key]["Address"] = '';
            $blogdata[$key]["Website"] = '';
         }
      }
   ```