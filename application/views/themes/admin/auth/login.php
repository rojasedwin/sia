<main class="page-content login">
    <div class="page-inner login"  >
        <div id="main-wrapper">
            <div class="row login_pane" id="login_pane">
                <div class="col-md-3 center">
                    <div class="login-box">
                        <a href="index.html" class="logo-name text-lg text-center">
                            <img src="<?=base_url()?>assets/themes/admin/images/logoWhite.png" style="width: 350px;"/>
                        </a>
                        <p class="text-center m-t-md"><?php echo $this->lang->line('page_title');?></p>
                        <form role="form" id="form-login" name="form-login" action="<?php echo base_url();?>auth/authenticate" method="post">
                            <div class="form-group">
								<input type="text" class="form-control" name="email" placeholder="<?php echo $this->lang->line('lbl_email');?>" id="email">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="password" placeholder="<?php echo $this->lang->line('lbl_password');?>" id="password">
                            </div>
                            <div class="form-group">
								<div id="div-login_message" class="alert alert-danger" style="display:none;">
									<p></p>
								</div>
							</div>
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>"/>
							<input type="hidden" name="return_url" value="<?php echo base64_decode($this->uri->segment(3));?>"/>
					
                            <button type="button" id="btn-login" class="btn btn-success btn-block"><?php echo $this->lang->line('btn_login');?></button>
                            <!--<a href="#" id="a_remember" class="btn btn-info btn-block m-t-md"><?php echo $this->lang->line('txt_forgot_password');?></a>
                            <a href="#" id="a_register" class="btn btn-default btn-block m-t-md"><?php echo $this->lang->line('txt_want_to_register');?></a>-->
                        </form>
                    </div>
                </div>
            </div><!-- Row -->

            <div class="row login_pane" id="register_pane">
                <div class="col-md-3 center">
                    <div class="login-box">
                        <a href="index.html" class="logo-name text-lg text-center">LOGO</a>
                        <p class="text-center m-t-md"><?php echo $this->lang->line('page_title');?></p>
                        <form role="form" id="form-register" name="form-register" action="<?php echo base_url();?>auth/register" method="post">
                            <div class="form-group">
                                <input type="text" class="form-control" name="email" placeholder="<?php echo $this->lang->line('lbl_email');?>" id="email">
                            </div>
                            <div class="form-group">
								<div id="div-register_message" class="alert alert-info" style="display:none;">
									<p></p>
								</div>
							</div>
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>"/>
							<input type="hidden" name="return_url" value="<?php echo base64_decode($this->uri->segment(3));?>"/>
					
                            <button type="button" class="btn btn-default btn-block m-t-xs"><?php echo $this->lang->line('btn_register');?></button>
                            <a href="#" class="btn btn-success btn-block m-t-md a_login"><?php echo $this->lang->line('btn_login');?></a>
                        </form>
                    </div>
                </div>
            </div><!-- Row -->

            <div class="row login_pane" id="remember_pane">
                <div class="col-md-3 center">
                    <div class="login-box">
                        <a href="index.html" class="logo-name text-lg text-center">LOGO</a>
                        <p class="text-center m-t-md">---</p>
                        <form role="form" id="form-remember" name="form-remember" action="<?php echo base_url();?>auth/remember" method="post">
                            <div class="form-group">
                                <input type="email" class="form-control" placeholder="Email" required>
                            </div>
                            <div class="form-group">
								<div id="div-remember_message" class="alert alert-info" style="display:none;">
									<p></p>
								</div>
							</div>
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>"/>
							<input type="hidden" name="return_url" value="<?php echo base64_decode($this->uri->segment(3));?>"/>
                            <button type="button" id="btn-remember" class="btn btn-info btn-block"><?php echo $this->lang->line('btn_remember');?></button>
                            <a href="#" class="btn btn-success btn-block m-t-md a_login"><?php echo $this->lang->line('btn_login');?></a>
                        </form>
                    </div>
                </div>
            </div><!-- Row -->
        </div><!-- Main Wrapper -->
    </div><!-- Page Inner -->
</main><!-- Page Content -->