<?php echo $header; ?>
<div id="content">
    <div class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <?php echo $breadcrumb['separator']; ?><a
                href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
        <?php } ?>
    </div>
    <?php if ($error_warning) { ?>
    <div class="warning"><?php echo $error_warning; ?></div>
    <?php } ?>
    <div class="box">
        <div class="heading">
            <h1><?php echo $heading_title; ?></h1>
            <div class="buttons">
                <a onclick="$('#form').submit();" class="button">
                    <?php echo $button_save; ?>
                </a>
                <a onclick="location = '<?php echo $cancel; ?>';" class="button">
                    <?php echo $button_cancel; ?>
                </a>
            </div>
        </div>
        <div class="content">
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
                <table class="form">
                    <tr>
                        <td>
                            <?php echo $entry_test; ?>
                        </td>
                        <td>
                            <select name="simplepay_test">
                                <?php if ($simplepay_test) { ?>
                                <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                                <option value="0"><?php echo $text_no; ?></option>
                                <?php } else { ?>
                                <option value="1"><?php echo $text_yes; ?></option>
                                <option value="0" selected="selected"><?php echo $text_no; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $entry_private_live_key; ?>
                        </td>
                        <td>
                            <input type="text"
                                   name="simplepay_private_live_key"
                                   value="<?php echo $simplepay_private_live_key; ?>"
                                   placeholder="<?php echo $entry_private_live_key; ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $entry_public_live_key; ?>
                        </td>
                        <td>
                            <input type="text"
                                   name="simplepay_public_live_key"
                                   value="<?php echo $simplepay_public_live_key; ?>"
                                   placeholder="<?php echo $entry_public_live_key; ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="required">*</span> <?php echo $entry_private_test_key; ?>
                        </td>
                        <td>
                            <input type="text"
                                   name="simplepay_private_test_key"
                                   value="<?php echo $simplepay_private_test_key; ?>"
                                   placeholder="<?php echo $entry_private_test_key; ?>"
                                   required/>
                            <?php if ($error_private_test_key) { ?>
                            <span class="error"><?php echo $error_private_test_key; ?></span>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="required">*</span> <?php echo $entry_public_test_key; ?>
                        </td>
                        <td>
                            <input type="text"
                                   name="simplepay_public_test_key"
                                   value="<?php echo $simplepay_public_test_key; ?>"
                                   placeholder="<?php echo $entry_public_test_key; ?>"
                                   required/>
                            <?php if ($error_public_test_key) { ?>
                            <span class="error"><?php echo $error_public_test_key; ?></span>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $entry_description; ?>
                        </td>
                        <td>
                            <input type="text"
                                   name="simplepay_description"
                                   value="<?php echo $simplepay_description; ?>"
                                   placeholder="<?php echo $entry_description; ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $entry_image; ?>
                        </td>
                        <td>
                            <input type="text"
                                   name="simplepay_image"
                                   value="<?php echo $simplepay_image; ?>"
                                   placeholder="<?php echo $entry_image; ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $entry_status; ?>
                        </td>
                        <td>
                            <select name="simplepay_status">
                                <?php if ($simplepay_status) { ?>
                                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                <option value="0"><?php echo $text_disabled; ?></option>
                                <?php } else { ?>
                                <option value="1"><?php echo $text_enabled; ?></option>
                                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $entry_sort_order; ?></td>
                        <td><input type="text" name="simplepay_sort_order"
                                   value="<?php echo $simplepay_sort_order; ?>" size="1"/></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
<?php echo $footer; ?>
