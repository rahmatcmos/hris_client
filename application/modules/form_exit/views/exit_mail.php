<div class="grid-body no-border">
                 <?php echo form_open("form_exit/add",array("id"=>"formaddexit"));
                    foreach($form_exit->result() as $row):
                 ?>
                <div class="row column-seperation">
                  <div class="col-md-12">    
                    <div class="row form-row">
                      <div class="col-md-2">
                        <label class="form-label text-right">Nama</label>
                      </div>
                      <div class="col-md-3">
                          <input name="emp" id="emp" type="text"  class="form-control" placeholder="Nama Karyawan" value="<?php echo get_name($row->user_id)?>" disabled="disabled">
                      </div>

                      <div class="col-md-2">
                        <label class="form-label text-right">Wilayah</label>
                      </div>
                      <div class="col-md-3">
                        <input name="emp" id="emp" type="text"  class="form-control" placeholder="Nama Karyawan" value="<?php echo $user_info['BU']?>" disabled="disabled">
                      </div>

                    </div>

                    <div class="row form-row">
                      <div class="col-md-2">
                        <label class="form-label text-right">NIK</label>
                      </div>
                      <div class="col-md-3">
                        <input name="emp" id="emp" type="text"  class="form-control" placeholder="Nama Karyawan" value="<?php echo $user_info['EMPLID']?>" disabled="disabled">
                      </div>
                      <div class="col-md-2">
                        <label class="form-label text-right">Dept/Bagian</label>
                      </div>
                      <div class="col-md-3">
                        <input name="emp" id="emp" type="text"  class="form-control" placeholder="Nama Karyawan" value="<?php echo $user_info['ORGANIZATION']?>" disabled="disabled">
                      </div>
                    </div>
                    <div class="row form-row">
                      <div class="col-md-2">
                        <label class="form-label text-right">Jabatan</label>
                      </div>
                      <div class="col-md-3">
                        <input name="emp" id="emp" type="text"  class="form-control" placeholder="Nama Karyawan" value="<?php echo $user_info['POSITION']?>" disabled="disabled">
                      </div>
                      <div class="col-md-2">
                        <label class="form-label text-right">Tanggal Keluar</label>
                      </div>
                      <div class="col-md-3">
                          <input type="text" class="form-control" id="sandbox-advance" name="date_exit" value="<?php echo dateIndo($row->date_exit)?>" disabled="disabled">    
                      </div>
                    </div>
                      
                      <p class="error_msg" id="MsgBad" style="background: #fff; display: none;"></p>
                      <div class="row form-row">
                        <div class="col-md-12">
                          <h4>Inventaris yang harus diserahkan</h4>
                        </div>
                      </div>
                      <div class="row form-row">
                        <div class="col-md-12">
                          <table class="table no-more-tables">
                            <tr>
                              <th>No</th>
                              <th>Item</th>
                              <th>Ketersediaan</th>
                              <th>Keterangan</th>
                            </tr>
                            <tr>
                              <td>1</td>
                              <td>Baju Seragam</td>
                              <td>
                                  <?php $seragam = ($inventaris->is_seragam == 1) ? 'Ada' : 'Tidak';?>
                                  <div class="radio">
                                      <input id="seragam" type="radio" name="seragamn" value="<?php echo $inventaris->is_seragam?>" checked="checked">
                                    <label for="seragam"><?php echo $seragam?></label>
                                  </div>
                              </td>
                              <td><input name="keterangan_seragam" id="form3LastName" type="text"  class="form-control" placeholder="" value="<?php echo $inventaris->keterangan_seragam?>" disabled="disabled"></td>
                            </tr>
                            <tr>
                              <td>2</td>
                              <td>ID Card</td>
                              <td>
                                <?php $id_card = ($inventaris->is_id_card == 1) ? 'Ada' : 'Tidak';?>
                                  <div class="radio">
                                      <input id="id_card" type="radio" name="id_card" value="<?php echo $inventaris->is_id_card?>" checked="checked">
                                    <label for="id_card"><?php echo $id_card?></label>
                                  </div>
                              </td>
                              <td><input name="keterangan_id_card" id="form3LastName" type="text"  class="form-control" placeholder="" value="<?php echo $inventaris->keterangan_id_card?>" disabled="disabled"></td>
                            </tr>
                            <tr>
                              <td>3</td>
                              <td>Sepeda motor / mobil</td>
                              <td>
                                <?php $kendaraan = ($inventaris->is_kendaraan == 1) ? 'Ada' : 'Tidak';?>
                                  <div class="radio">
                                      <input id="kendaraan" type="radio" name="kendaraan" value="<?php echo $inventaris->is_kendaraan?>" checked="checked">
                                    <label for="kendaraan"><?php echo $kendaraan?></label>
                                  </div>
                              </td>
                              <td><input name="keterangan_kendaraan" id="form3LastName" type="text"  class="form-control" placeholder="" value="<?php echo $inventaris->keterangan_kendaraan?>" disabled="disabled"></td>
                            </tr>
                            <tr>
                              <td>4</td>
                              <td>STNK motor / mobil</td>
                              <td>
                                <?php $stnk = ($inventaris->is_stnk == 1) ? 'Ada' : 'Tidak';?>
                                  <div class="radio">
                                      <input id="stnk" type="radio" name="stnk" value="<?php echo $inventaris->is_stnk?>" checked="checked">
                                    <label for="stnk"><?php echo $stnk?></label>
                                  </div>
                              </td>
                              <td><input name="keterangan_stnk" id="form3LastName" type="text"  class="form-control" placeholder="" value="<?php echo $inventaris->keterangan_stnk?>" disabled="disabled"></td>
                            </tr>
                            <tr>
                              <td>5</td>
                              <td>HP/Laptop/Ipad</td>
                              <td>
                                <?php $gadget = ($inventaris->is_gadget == 1) ? 'Ada' : 'Tidak';?>
                                  <div class="radio">
                                      <input id="gadget" type="radio" name="gadget" value="<?php echo $inventaris->is_gadget?>" checked="checked">
                                    <label for="gadget"><?php echo $gadget?></label>
                                  </div>
                              </td>
                              <td><input name="keterangan_gadget" id="keterangan" type="text"  class="form-control" placeholder="" value="<?php echo $inventaris->keterangan_gadget?>" disabled="disabled"></td>
                            </tr>
                            <tr>
                              <td>6</td>
                              <td>Laporan serah terima</td>
                              <td>
                                <?php $laporan = ($inventaris->is_laporan == 1) ? 'Ada' : 'Tidak';?>
                                  <div class="radio">
                                      <input id="laporan" type="radio" name="laporan" value="<?php echo $inventaris->is_laporan?>" checked="checked">
                                    <label for="laporan"><?php echo $laporan?></label>
                                  </div>
                              </td>
                              <td><input name="keterangan_laporan" id="form3LastName" type="text"  class="form-control" placeholder="" value="<?php echo $inventaris->keterangan_laporan?>" disabled="disabled"></td>
                            </tr>
                            <tr>
                              <td>7</td>
                              <td>Rekonsiliasi Saldo</td>
                              <td>
                                <?php $saldo = ($inventaris->is_saldo == 1) ? 'Ada' : 'Tidak';?>
                                  <div class="radio">
                                      <input id="saldo" type="radio" name="saldo" value="<?php echo $inventaris->is_saldo?>" checked="checked">
                                    <label for="saldo"><?php echo $saldo?></label>
                                  </div>
                              </td>
                              <td><input name="keterangan_saldo" id="form3LastName" type="text"  class="form-control" placeholder="" value="<?php echo $inventaris->keterangan_saldo?>" disabled="disabled"></td>
                            </tr>
                            <tr>
                              <td>8</td>
                              <td>Pinjaman Koperasi</td>
                              <td>
                                <?php $pinjaman_koperasi = ($inventaris->is_pinjaman_koperasi == 1) ? 'Ada' : 'Tidak';?>
                                  <div class="radio">
                                      <input id="pinjaman_koperasi" type="radio" name="pinjaman_koperasi" value="<?php echo $inventaris->is_pinjaman_koperasi?>" checked="checked">
                                    <label for="pinjaman_koperasi"><?php echo $pinjaman_koperasi?></label>
                                  </div>
                              </td>
                              <td><input name="keterangan_koperasi" id="form3LastName" type="text"  class="form-control" placeholder="" value="<?php echo $inventaris->keterangan_pinjaman_koperasi?>" disabled="disabled"></td>
                            </tr>
                            <tr>
                              <td>9</td>
                              <td>Pinjaman buku perpustakaan</td>
                              <td>
                                <?php $pinjaman_buku = ($inventaris->is_pinjaman_buku == 1) ? 'Ada' : 'Tidak';?>
                                  <div class="radio">
                                      <input id="pinjaman_buku" type="radio" name="pinjaman_buku" value="<?php echo $inventaris->is_pinjaman_buku?>" checked="checked">
                                    <label for="pinjaman_buku"><?php echo $pinjaman_buku?></label>
                                  </div>
                              </td>
                              <td><input name="keterangan_buku" id="form3LastName" type="text"  class="form-control" placeholder="" value="<?php echo $inventaris->keterangan_pinjaman_buku?>" disabled="disabled"></td>
                            </tr>
                            <tr>
                              <td>10</td>
                              <td>Ikatan dinas</td>
                              <td>
                                <?php $ikatan = ($inventaris->is_ikatan == 1) ? 'Ada' : 'Tidak';?>
                                  <div class="radio">
                                      <input id="ikatan" type="radio" name="ikatan" value="<?php echo $inventaris->is_ikatan?>" checked="checked">
                                    <label for="ikatan"><?php echo $ikatan?></label>
                                  </div>
                              </td>
                              <td><input name="keterangan_ikatan" id="form3LastName" type="text"  class="form-control" placeholder="" value="<?php echo $inventaris->keterangan_ikatan?>" disabled="disabled"></td>
                            </tr>
                          </table>
                        </div>
                      </div>
                      
                  <div class="form-actions">
                      <div class="col-md-12 text-center"><div class="col-md-12 text-center"><span class="semi-bold">Mengetahui,</span><br/><br/><br/></div>
                      <div class="row wf-cuti">
                        <div class="col-md-3">
                          <p class="wf-approve-sp">
                            <?php if($row->is_app_mgr == 1){?>
                            <span class="semi-bold"><?php echo get_name($mgr_ga_nas)?></span><br/>
                            <span class="small"><?php echo dateIndo($row->date_app_mgr)?></span><br/>
                            <?php }else{ ?>
                            <span class="semi-bold"></span><br/>
                            <span class="small"></span><br/>
                            <?php } ?>
                            <span class="semi-bold"></span><br/>
                            <span class="semi-bold">Mgr GA Nasional</span>
                          </p>
                        </div>

                        <div class="col-md-3">
                          <p class="wf-approve-sp">
                            <?php if($row->is_app_mgr == 1){?>
                            <span class="semi-bold"><?php echo get_name($koperasi)?></span><br/>
                            <span class="small"><?php echo dateIndo($row->date_app_koperasi)?></span><br/>
                            <?php }else{ ?>
                            <span class="semi-bold"></span><br/>
                            <span class="small"></span><br/>
                            <?php } ?>
                            <span class="semi-bold"></span><br/>
                            <span class="semi-bold">Sie Koperasi</span>
                          </p>
                        </div>
                          
                        <div class="col-md-3">
                          <p class="wf-approve-sp">
                            <?php if($row->is_app_mgr == 1){?>
                            <span class="semi-bold"><?php echo get_name($perpustakaan)?></span><br/>
                            <span class="small"><?php echo dateIndo($row->date_app_perpus)?></span><br/>
                            <?php }else{ ?>
                            <span class="semi-bold"></span><br/>
                            <span class="small"></span><br/>
                            <?php } ?>
                            <span class="semi-bold"></span><br/>
                            <span class="semi-bold">Perpustakaan</span>
                          </p>
                        </div>
                          
                        <div class="col-md-3">
                          <p class="wf-approve-sp">
                            <?php if($row->is_app_mgr == 1){?>
                            <span class="semi-bold"><?php echo get_name($hrd)?></span><br/>
                            <span class="small"><?php echo dateIndo($row->date_app_hrd)?></span><br/>
                            <?php }else{ ?>
                            <span class="semi-bold"></span><br/>
                            <span class="small"></span><br/>
                            <?php } ?>
                            <span class="semi-bold"></span><br/>
                            <span class="semi-bold">HRD Database</span>
                          </p>
                        </div>
                        <!--PST242, PST263, PST2, PST129-->
                      </div>
                    </div> 
                  </div>
                      
                      
                      
                        <div class="row form-row">
                          <div class="col-md-12">
                              <h4><br />Kami rekomendasikan kepada karyawan tersebut</h4>
                          </div>
                        </div>
                        <div class="row form-row">
                        <div class="col-md-12">
                          <table class="table no-more-tables">
                            <tr>
                              <td>1</td>
                              <td>Diberikan Uang Pesangon</td>
                              <td>
                                <?php $pesangon = ($rekomendasi->is_pesangon == 1) ? 'Ada' : 'Tidak';?>
                                  <div class="radio">
                                      <input id="pesangon" type="radio" name="pesangon" value="<?php echo $rekomendasi->is_pesangon?>" checked="checked">
                                    <label for="pesangon"><?php echo $pesangon?></label>
                                  </div>
                              </td>
                            </tr>
                            <tr>
                              <td>2</td>
                              <td>Diberikan uang pengganti hak</td>
                              <td>
                                <?php $uang_ganti = ($rekomendasi->is_uang_ganti == 1) ? 'Ada' : 'Tidak';?>
                                  <div class="radio">
                                      <input id="uang_ganti" type="radio" name="uang_ganti" value="<?php echo $rekomendasi->is_uang_ganti?>" checked="checked">
                                    <label for="uang_ganti"><?php echo $uang_ganti?></label>
                                  </div>
                              </td>
                            </tr>
                            <tr>
                              <td>3</td>
                              <td>Diberikan uang jasa</td>
                              <td>
                                <?php $uang_jasa = ($rekomendasi->is_uang_jasa == 1) ? 'Ada' : 'Tidak';?>
                                  <div class="radio">
                                      <input id="uang_jasa" type="radio" name="uang_jasa" value="<?php echo $rekomendasi->is_uang_jasa?>" checked="checked">
                                    <label for="uang_jasa"><?php echo $uang_jasa?></label>
                                  </div>
                              </td>
                            </tr>
                            <tr>
                              <td>4</td>
                              <td>Diberikan surat keterangan kerja</td>
                              <td>
                                <?php $sk_kerja = ($rekomendasi->is_sk_kerja == 1) ? 'Ada' : 'Tidak';?>
                                  <div class="radio">
                                      <input id="sk_kerja" type="radio" name="sk_kerja" value="<?php echo $rekomendasi->is_sk_kerja?>" checked="checked">
                                    <label for="sk_kerja"><?php echo $sk_kerja?></label>
                                  </div>
                              </td>
                            </tr>
                            <tr>
                              <td>5</td>
                              <td>Diberikan ijazah asli ybs</td>
                              <td>
                                <?php $ijazah = ($rekomendasi->is_ijazah == 1) ? 'Ada' : 'Tidak';?>
                                  <div class="radio">
                                      <input id="ijazah" type="radio" name="ijazah" value="<?php echo $rekomendasi->is_ijazah?>" checked="checked">
                                    <label for="ijazah"><?php echo $ijazah?></label>
                                  </div>
                              </td>
                            </tr>
                          </table>
                        </div>

                        
                      
                  </div>
                  <div class="row form-row">
                    <div class="col-md-12">
                      <label class="form-label text-left">Catatan Khusus</label>
                    </div>
                    <div class="col-md-12">
                      <textarea name="note_app" id="text-editor" placeholder="Enter text ..." class="form-control" rows="10" disabled="disabled"><?php echo $row->note_app?></textarea>
                    </div>
                  </div>
                  <div class="form-actions">
                    <div class="col-md-12 text-center">
                      <div class="row wf-cuti">
                        <div class="col-md-4">
                          Hormat Kami,<br/><br/>
                          <p class="wf-approve-sp">
                            <span class="semi-bold"><?php echo get_name(get_superior($row->user_id))?></span><br/>
                            <span class="small"><?php echo dateIndo($row->created_on)?></span><br/>
                            <span class="semi-bold"></span><br/>
                            <span class="semi-bold">Atasan Langsung</span>
                          </p>
                        </div>

                        <div class="col-md-4"></div>
                        
                        <div class="col-md-4">
                          Mengetahui / Menyetujui,<br/><br/>
                          <p class="wf-approve-sp">
                            <?php if($row->is_app==1){?>
                            <span class="semi-bold"><?php echo get_name($row->user_app)?></span><br/>
                            <span class="small"><?php echo dateIndo($row->date_app)?><br/>  
                            <span class="semi-bold"></span><br/>
                            <?php }else{?>
                            <span class="semi-bold"></span><br/>
                            <span class="semi-bold"></span><br/>
                            <span class="semi-bold"></span><br/>
                            <?php } ?>
                            <span class="semi-bold">ASM/Mgr/Kacab/BDM/CoE</span>
                          </p>
                        </div>
                      </div>
                    </div> 
                  </div>
                </div>
                      <?php endforeach;?>
                </form>