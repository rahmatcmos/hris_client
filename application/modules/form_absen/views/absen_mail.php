<div id="container">
        <div class="row">
        <div class="col-md-12">
          <div class="grid simple">
            <div class="grid-title no-border">
              <h4>Form Keterangan Tidak <a href="<?php echo site_url('form_absen')?>"><span class="semi-bold">Absen</span></a></h4><br/>
              No : <?= get_form_no($id) ?>
            </div>
            <div class="grid-body no-border">
            <?php 
            if($_num_rows>0){
              foreach($form_absen as $absen){?>
              <form class="form-no-horizontal-spacing" id="formAbsen"> 
                <div class="row column-seperation">
                  <div class="col-md-12">    
                    <div class="row form-row">
                      <div class="col-md-3">
                        <label class="form-label text-right">No</label>
                      </div>
                      <div class="col-md-9">
                        <input name="form3LastName" id="form3LastName" type="text"  class="form-control" placeholder="Nama" value="<?php echo $absen->id?>" disabled="disabled">
                      </div>
                    </div>
                    <div class="row form-row">
                      <div class="col-md-3">
                        <label class="form-label text-right">Tanggal</label>
                      </div>
                      <div class="col-md-8">
                        <div class="input-append success no-padding">
                          <input type="text" class="form-control" name="date_tidak_hadir" value="<?php echo dateIndo($absen->date_tidak_hadir)?>" disabled="disabled">
                        </div>
                      </div>
                    </div>
                    <div class="row form-row">
                      <div class="col-md-3">
                        <label class="form-label text-right">Nama</label>
                      </div>
                      <div class="col-md-9">
                        <input name="form3LastName" id="form3LastName" type="text"  class="form-control" placeholder="Nama" value="<?php echo get_name($absen->user_id)?>" disabled="disabled">
                      </div>
                    </div>
                    <div class="row form-row">
                      <div class="col-md-3">
                        <label class="form-label text-right">Dept/Bagian</label>
                      </div>
                      <div class="col-md-9">
                        <input name="form3LastName" id="form3LastName" type="text"  class="form-control" placeholder="Nama" value="<?php echo get_user_organization($user_nik)?>" disabled="disabled">
                      </div>
                    </div>
                    <div class="row form-row">
                      <div class="col-md-3">
                        <label class="form-label text-right">Keterangan</label>
                      </div>
                      <div class="col-md-9">
                        <div class="radio">
                          <?php 
                        if($absen->keterangan_id!=0){?>
                          <input checked="checked" id="tidak_absen_in" type="radio" name="keterangan" value="<?php echo $absen->keterangan_id?>">
                          <label for="<?php echo $absen->keterangan_absen;?>"><?php echo $absen->keterangan_absen;?></label>
                        <?php }else{?>
                          <input checked="checked" id="tidak_absen_in" type="radio" name="keterangan" value="0">
                          <label for="nO dATA">No Data</label>
                          <?php } ?>
                        </div>
                      </div>
                    </div>
                    <div class="row form-row">
                      <div class="col-md-3">
                        <label class="form-label text-right">Alasan</label>
                      </div>
                      <div class="col-md-9">
                        <input name="form3LastName" id="form3LastName" type="text"  class="form-control" placeholder="Alasan" value="<?php echo $absen->alasan?>" disabled="disabled">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-actions">
                      <div class="col-md-12 text-center"><div class="col-md-12 text-center"><span class="semi-bold">Mengetahui,</span><br/><br/><br/></div>
                      <div class="row wf-cuti">
                        <div class="col-md-3">
                          <p class="wf-approve-sp">
                            <?php
                            $approved = assets_url('img/approved_stamp.png');
                            if(!empty($absen->user_app_lv1) && $absen->is_app_lv1 == 0 && get_nik($sess_id) == $absen->user_app_lv1){?>
                              <span class="semi-bold"></span><br/>
                              <span class="semi-bold"></span><br/>
                              <span class="small"></span><br/>
                              <span class="semi-bold"></span><br/>
                              <span class="semi-bold">(Atasan Langsung)</span>
                            <?php }elseif(!empty($absen->user_app_lv1) && $absen->is_app_lv1 == 1){
                              echo "<img class=approval_img_md src=$approved>"?>
                              <span class="small"></span><br/>
                              <span class="semi-bold"><?php echo get_name($absen->user_app_lv1)?></span><br/>
                              <span class="small"><?php echo dateIndo($absen->date_app_lv1)?></span><br/>
                              <span class="semi-bold">(Atasan Langsung)</span>
                            <?php }else{?>
                              <span class="small"></span><br/>
                              <span class="small"></span><br/>
                              <span class="semi-bold"></span><br/>
                              <span class="semi-bold"><?php echo get_name($absen->user_app_lv1)?></span><br/>
                              <span class="small"><?php echo dateIndo($absen->date_app_lv1)?></span><br/>
                              <span class="semi-bold">(Atasan Langsung)</span>
                            <?php } ?>
                          </p>
                        </div>

                        <div class="col-md-3">
                        <?php if(!empty($absen->user_app_lv2)) : ?>
                          <p class="wf-approve-sp">
                            <?php
                            if(!empty($absen->user_app_lv2) && $absen->is_app_lv2 == 0 && get_nik($sess_id) == $absen->user_app_lv2){?>
                              <span class="semi-bold"></span><br/>
                              <span class="semi-bold"></span><br/>
                              <span class="small"></span><br/>
                              <span class="semi-bold"></span><br/>
                              <span class="semi-bold">(Atasan Tidak Langsung)</span>
                            <?php }elseif(!empty($absen->user_app_lv2) && $absen->is_app_lv2 == 1){
                              echo "<img class=approval_img_md src=$approved>"?>
                              <span class="small"></span><br/>
                              <span class="semi-bold"><?php echo get_name($absen->user_app_lv2)?></span><br/>
                              <span class="small"><?php echo dateIndo($absen->date_app_lv2)?></span><br/>
                              <span class="semi-bold">(Atasan Tidak Langsung)</span>
                            <?php }else{?>
                              <span class="small"></span><br/>
                              <span class="small"></span><br/>
                              <span class="semi-bold"></span><br/>
                              <span class="semi-bold"><?php echo get_name($absen->user_app_lv2)?></span><br/>
                              <span class="small"><?php echo dateIndo($absen->date_app_lv2)?></span><br/>
                              <span class="semi-bold">(Atasan Tidak Langsung)</span>
                            <?php } ?>
                          </p>
                        <?php endif; ?>
                        </div>
                          
                        <div class="col-md-3">
                        <?php if(!empty($absen->user_app_lv3)) : ?>
                          <p class="wf-approve-sp">
                            <?php
                            if(!empty($absen->user_app_lv3) && $absen->is_app_lv3 == 0 && get_nik($sess_id) == $absen->user_app_lv3){?>
                              <span class="semi-bold"></span><br/>
                              <span class="semi-bold"></span><br/>
                              <span class="small"></span><br/>
                              <span class="semi-bold"></span><br/>
                              <span class="semi-bold">(<?php echo get_user_position($absen->user_app_lv3)?>)</span>
                            <?php }elseif(!empty($absen->user_app_lv3) && $absen->is_app_lv3 == 1){
                              echo "<img class=approval_img_md src=$approved>"?>
                              <span class="small"></span><br/>
                              <span class="semi-bold"><?php echo get_name($absen->user_app_lv3)?></span><br/>
                              <span class="small"><?php echo dateIndo($absen->date_app_lv3)?></span><br/>
                              <span class="semi-bold">(<?php echo get_user_position($absen->user_app_lv3)?>)</span>
                            <?php }else{?>
                              <span class="small"></span><br/>
                              <span class="small"></span><br/>
                              <span class="semi-bold"></span><br/>
                              <span class="semi-bold"><?php echo get_name($absen->user_app_lv3)?></span><br/>
                              <span class="small"><?php echo dateIndo($absen->date_app_lv3)?></span><br/>
                              <span class="semi-bold">(<?php echo get_user_position($absen->user_app_lv3)?>)</span>
                            <?php } ?>
                          </p>
                        <?php endif; ?>
                        </div>
                          
                        <div class="col-md-3">
                          <p class="wf-approve-sp">
                            <?php
                            if($absen->is_app_hrd == 0 && $this->approval->approver('absen') == $sess_nik){?>
                              <span class="semi-bold"></span><br/>
                              <span class="semi-bold"></span><br/>
                              <span class="small"></span><br/>
                              <span class="semi-bold"></span><br/>
                              <span class="semi-bold">(HRD)</span>
                            <?php }elseif($absen->is_app_hrd == 1){
                              echo "<img class=approval_img_md src=$approved>"?>
                              <span class="small"></span><br/>
                              <span class="semi-bold"><?php echo get_name($absen->user_app_hrd)?></span><br/>
                              <span class="small"><?php echo dateIndo($absen->date_app_hrd)?></span><br/>
                              <span class="semi-bold">(HRD)</span>
                            <?php }else{?>
                              <span class="small"></span><br/>
                              <span class="small"></span><br/>
                              <span class="semi-bold"></span><br/>
                              <span class="semi-bold"><?php echo get_name($this->approval->approver('absen'))?></span><br/>
                              <span class="small"><?php echo dateIndo($absen->date_app_hrd)?></span><br/>
                              <span class="semi-bold">(HRD)</span>
                            <?php } ?>
                          </p>
                        </div>
                      </div>
                    </div> 
                  </div>
              </form>
              <?php }}?>
            </div>
          </div>
        </div>
      </div>