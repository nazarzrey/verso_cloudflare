<div class="main-content">
    <div class="col-lg-12" style="margin:0">
          <ul class="nav nav-tabs" id="myTab" role="tablist" style="margin-top:-10px">
                <li class="nav-item">
                  <a class="nav-link cl-db active  ver-clr4" data-toggle="tab" href="#user-profile" role="tab" aria-controls="lapak" aria-selected="false">Profile</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link cl-db ver-clr4" data-toggle="tab" href="#user-password" role="tab" aria-controls="cki" aria-selected="false">Password</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link cl-db ver-clr4" data-toggle="tab" href="#user-email" role="tab" aria-controls="lebak" aria-selected="true">Email</a>
                </li>
            </ul>
            <div class="row" style="margin-top: 10px">
                <div class="tab-content data_profile" id="myTabContent">
                    <div class="tab-pane fade show active" id="user-profile" role="tabpanel">
                        <div id="edit" style="">        
                            <section id="profile_user_edit" style="margin:0;padding: 0;width: 100%;overflow: hidden;margin-bottom: 20px">
                                <div class="profile_pict no_mp">
                                    <div>
                                      <img src="<?= get_img("profile") ?>" class="profile_img">
                                    </div>
                                    <div class="profile_button">
                                        <a href="profile_edit.html#edit_imgpro" class="button3 wx200 f14 ver-brd4" style="margin:8px">CHANGE PICTURE</a><br>
                                        <a href="profile_edit.html#del_imgpro" class="button3 wx200 f14 ver-brd4" style="margin:8px">DELETE PICTURE</a>
                                    </div>
                                </div>
                            </section>  
                            <section>
                              <form method="post" id="xsave_prof" enctype="multipart/form-data">
                                <table width="100%">
                                    <tbody><tr class="hilang">
                                        <td width="17%">uid</td>
                                        <td><input type="text" name="uid" value="20"></td>
                                    </tr>
                                    <tr>
                                        <td width="17%" class="hm">Name</td>
                                        <td>
                                        <b>Name</b>
                                        <input type="text" name="name" value="<?= ucwords(strtolower($session["uname"])); ?>"></td>
                                    </tr>
                                    <tr><td class="hm">Phone</td>
                                        <td>
                                        <b>Phone</b>
                                            <input type="text" name="phn" id="phn" value="<?= ucwords(strtolower($session["uph"])); ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="hm">Gender</td>
                                        <td>
                                        <b>Gender</b>                       
                                        <select name="gender" id="gender">
                                            <option value="U">Gender</option><<option value="P">Female</option><option value="L">Male</option>
                                        </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="hm">Date Of Birth</td>
                                        <td>
                                        <b>Date Of Birth</b>                        
                                            <select name="brn_d" style="width:31.9%">
                                                <option value="0">Date</option>
                                                <option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option>                          </select>              
                                            <select name="brn_m" style="width:31.9%;margin:0 1.5%">
                                                <option value="0">Month</option>
                                                <option value="1">January</option><option value="2">February</option><option value="3">March</option><option value="4">April</option><option value="5">May</option><option value="6">June</option><option value="7">July</option><option value="8">August</option><option value="9">September</option><option value="10">October</option><option value="11">November</option><option value="12">December</option>                           </select>                
                                            <select name="brn_y" style="width:31.9%;float:right">
                                                <option value="">Year</option>
                                                <option value="2019">2019</option><option value="2018">2018</option><option value="2017">2017</option><option value="2016">2016</option><option value="2015">2015</option><option value="2014">2014</option><option value="2013">2013</option><option value="2012">2012</option><option value="2011">2011</option><option value="2010">2010</option><option value="2009">2009</option><option value="2008">2008</option><option value="2007">2007</option><option value="2006">2006</option><option value="2005">2005</option><option value="2004">2004</option><option value="2003">2003</option><option value="2002">2002</option><option value="2001">2001</option><option value="2000">2000</option><option value="1999">1999</option><option value="1998">1998</option><option value="1997">1997</option><option value="1996">1996</option><option value="1995">1995</option><option value="1994">1994</option><option value="1993">1993</option><option value="1992">1992</option><option value="1991">1991</option><option value="1990">1990</option><option value="1989">1989</option><option value="1988">1988</option><option value="1987">1987</option><option value="1986">1986</option><option value="1985">1985</option><option value="1984">1984</option><option value="1983">1983</option><option value="1982">1982</option><option value="1981">1981</option><option value="1980">1980</option><option value="1979">1979</option><option value="1978">1978</option><option value="1977">1977</option><option value="1976">1976</option><option value="1975">1975</option><option value="1974">1974</option><option value="1973">1973</option><option value="1972">1972</option><option value="1971">1971</option><option value="1970">1970</option><option value="1969">1969</option><option value="1968">1968</option><option value="1967">1967</option><option value="1966">1966</option><option value="1965">1965</option><option value="1964">1964</option><option value="1963">1963</option><option value="1962">1962</option><option value="1961">1961</option><option value="1960">1960</option><option value="1959">1959</option><option value="1958">1958</option><option value="1957">1957</option><option value="1956">1956</option><option value="1955">1955</option><option value="1954">1954</option><option value="1953">1953</option><option value="1952">1952</option><option value="1951">1951</option><option value="1950">1950</option><option value="1949">1949</option><option value="1948">1948</option><option value="1947">1947</option><option value="1946">1946</option><option value="1945">1945</option><option value="1944">1944</option><option value="1943">1943</option><option value="1942">1942</option><option value="1941">1941</option><option value="1940">1940</option><option value="1939">1939</option><option value="1938">1938</option><option value="1937">1937</option><option value="1936">1936</option><option value="1935">1935</option><option value="1934">1934</option><option value="1933">1933</option><option value="1932">1932</option><option value="1931">1931</option><option value="1930">1930</option><option value="1929">1929</option><option value="1928">1928</option><option value="1927">1927</option><option value="1926">1926</option><option value="1925">1925</option><option value="1924">1924</option><option value="1923">1923</option><option value="1922">1922</option><option value="1921">1921</option><option value="1920">1920</option><option value="1919">1919</option><option value="1918">1918</option><option value="1917">1917</option><option value="1916">1916</option><option value="1915">1915</option><option value="1914">1914</option><option value="1913">1913</option><option value="1912">1912</option><option value="1911">1911</option><option value="1910">1910</option><option value="1909">1909</option>                          </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="hm">Country City</td>
                                        <td>                            
                                        <b>Country</b>
                                        <input type="text" name="country" id="country" autocomplete="off" style="width:49%">
                                        <input type="text" name="city" id="country_city" autocomplete="off" style="width:49%;float:right">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="hm">Address</td>
                                        <td>
                                        <b>Address</b>
                                        <textarea name="address" placeholder="address detail"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="hm">Facebook Link</td>
                                        <td>
                                        <b>Facebook Link</b>
                                        <img src="<?= assets('images/icon/fb.png') ?>" style="position: absolute">
                                        <input type="text" style="padding-left:50px" name="fb" value="" placeholder="ex https://www.facebook.com/versoview/"></td>
                                    </tr>
                                    <tr>
                                        <td class="hm">Instagram Link</td>
                                        <td>
                                        <b>Instagram Link</b>
                                        <img src="<?= assets('images/icon/ig.png') ?>" style="position: absolute">
                                        <input type="text" style="padding-left:50px" name="ig" value="" placeholder="ex https://www.instagram.com/versoview/"></td>
                                    </tr>
                                    <tr>
                                        <td class="hm">Website Link</td>
                                        <td>
                                        <b>Website Link</b>
                                        <img src="<?= assets('images/icon/web.png') ?>" style="position: absolute">
                                            <input type="text" style="padding-left:50px" name="web" value="" placeholder="ex http://www.versoview.com/">
                                        </td>
                                    </tr>
                                    <tr><td></td></tr>
                                    <tr><td colspan="2">
                                    <input class="w100 button2 nbg clr_b save_pro" type="button" value="SAVE CHANGES" data-href="prof"></td></tr>
                                </tbody></table>
                              </form>
                            </section>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="user-email" role="tabpanel">
                        <div id="mail"> 
                          <form method="post" id="xsave_mail" enctype="multipart/form-data">
                            <section>
                                <table width="100%">
                                    <tbody><tr class="hilang">
                                        <td width="17%">uid</td>
                                        <td>
                                        <input type="text" name="uid" value="20"></td>
                                    </tr>
                                    <tr><td width="17%" class="hm">Old Email</td>
                                        <td>
                                        <b>Old Email</b>
                                        <input type="mail" name="mail" id="omail" class="ro" value="<?= strtolower($session["uem"]); ?>" readonly=""></td>
                                    </tr>
                                    <tr>
                                        <td class="hm">New Email</td>
                                        <td>
                                        <b>New Email</b>
                                        <input type="mail" name="nmail1" id="nmail1"></td>
                                    </tr>
                                    <tr>
                                        <td class="hm">Re-type New Email</td>
                                        <td>
                                        <b>Re-type New Email</b>
                                        <input type="mail" name="nmail2" id="nmail2"></td>
                                    </tr>
                                    <tr><td></td></tr>
                                    <tr><td colspan="2"><input class="w100 button nbg clr_b save_pro brd_gr" type="button" value="SAVE CHANGES" data-href="mail"></td></tr>
                                </tbody></table>
                            </section>
                          </form>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="user-password" role="tabpanel">
                        <div id="pwd">  
                          <form method="post" id="xsave_pass" enctype="multipart/form-data">
                            <section>
                                <table width="100%">
                                    <tbody><tr class="hilang">
                                        <td width="17%" class="hm">uid</td>
                                        <td><input type="password" name="uid" value="20"></td>
                                    </tr>
                                    <tr>
                                        <td class="hm">Old Password</td>
                                        <td>
                                        <b>Old Password</b>
                                        <input type="password" name="old_pass" id="opass" placeholder="password" value=""></td>
                                    </tr>
                                    <tr>
                                        <td width="17%" class="hm">New Password</td>
                                        <td>
                                        <b>New Password</b>
                                        <input type="password" name="new_pass1" id="npass1" placeholder="min 6 char"></td>
                                    </tr>
                                    <tr>
                                        <td class="hm">Re-type New Password</td>
                                        <td>
                                        <b>Re-type New Password</b>
                                        <input type="password" name="new_pass2" id="npass2" placeholder="min 6 char"></td>
                                    </tr>
                                    <tr><td></td></tr>
                                    <tr><td colspan="2" class="saved"><input class="w100 button nbg clr_b save_pro" type="button" value="SAVE CHANGES" data-href="pass"></td></tr>
                                </tbody></table>
                            </section>
                          </form>
                        </div>
                    </div>
                </div>
            </div>    
      <!--   <div class="card">
            <div class="card-body card-block">
                <form action="" method="post" class="">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" id="username2" name="username2" placeholder="Username" class="form-control">
                            <div class="input-group-addon">
                                <i class="fa fa-user"></i>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <input type="email" id="email2" name="email2" placeholder="Email" class="form-control">
                            <div class="input-group-addon">
                                <i class="fa fa-envelope"></i>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <input type="password" id="password2" name="password2" placeholder="Password" class="form-control">
                            <div class="input-group-addon">
                                <i class="fa fa-asterisk"></i>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions form-group">
                        <button type="submit" class="btn btn-secondary btn-sm">Submit</button>
                    </div>
                </form>
            </div> -->
        </div>
    </div>
</div>