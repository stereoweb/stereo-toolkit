<div class="wrap">
    <h1 class="wp-heading-inline">
        SEO Listing
    </h1>

    <div class="tablenav top">

        <div class="alignleft actions">
            <?=__('Columns', 'stereo')?>: &nbsp;&nbsp;
            <label for="fb-select">
                <input name="fbmeta" id="fb-select" type="checkbox"  />
                Facebook
            </label>&nbsp;&nbsp;
            <label for="tw-select">
                <input name="twmeta" id="tw-select" type="checkbox" />
                Twitter
            </label>
        </div>
        <br class="clear">
    </div>

    <nav class="nav-tab-wrapper">
        <?php foreach ($types as $post_type => $object) : ?>
            <a href="?page=stereo-seo-listing&tab=<?php echo $post_type; ?>" class="nav-tab <?php echo $tab == $post_type ? 'nav-tab-active' : ''; ?>">
                <?php echo $object->labels->singular_name; ?>
            </a>
        <?php endforeach; ?>
    </nav>

    <div class="tab-content stereo-form-meta-seo">
        <table class="wp-list-table widefat fixed striped table-view-list pages">
	        <thead>
	            <tr>
                    <th scope="col" id="title" class="manage-column column-title column-primary" width="150px">Title</th>
                    <th scope="col" class="manage-column">Slug</th>
                    <th scope="col" class="manage-column">Titles</th>
                    <th scope="col" class="manage-column">Meta description</th>
                    <th scope="col" class="manage-column fbshow" style="display:none">Facebook description</th>
                    <th scope="col" class="manage-column twshow" style="display:none">Twitter description</th>
                    <th scope="col" class="manage-column fbshow" style="display:none" width="105px"><?php if (defined('WPSEO_VERSION')) : ?>Facebook image<?php else:?>Social image<?php endif; ?></th>
                    <?php if (defined('WPSEO_VERSION')) : ?><th scope="col" class="manage-column twshow" style="display:none" width="105px">Twitter image</th><?php endif; ?>
                </tr>
	        </thead>
	        <tbody id="the-list">
            <?php while ($query->have_posts()) :
                $query->the_post();
                $metas = $this->get_seo_metas(get_the_ID());
            ?>
                <tr class="iedit type-page status-publish hentry" data-id="<?=get_the_ID()?>">
			        <td class="title column-title has-row-actions column-primary page-title" data-colname="Title">
                        <strong><?php the_title(); ?></strong>
                        <div class="row-actions"><span class="edit"><a href="/wp/wp-admin/post.php?post=<?=get_the_ID()?>&amp;action=edit" aria-label="Edit">Edit</a> | </span><span class="view"><a target="_blank" href="<?php the_permalink()?>" rel="bookmark" aria-label="View">View</a></span></div>
			        </th>
                    <td><input type="text" name="post_name" value="<?=get_post()->post_name?>"></td>
                    <td>
                        <label>
                            Title (<span class="count">count: <?=mb_strlen($metas['title'])?>)</span><input type="text" name="meta_title" value="<?=$metas['title']?>">
                        </label>
                        <label class="fbshow" style="display:none">
                            Facebook (<span class="count">count: <?=mb_strlen($metas['facebook_title'])?></span>)<input type="text" name="facebook_title" value="<?=$metas['facebook_title']?>">
                        </label>
                        <label class="twshow" style="display:none">
                            Twitter (<span class="count">count: <?=mb_strlen($metas['twitter_title'])?></span>)<input type="text" name="twitter_title" value="<?=$metas['twitter_title']?>">
                        </label>
                    </td>
                    <td><textarea name="meta_description" rows="7"><?=$metas['description']?></textarea><span class="count">count: <?=mb_strlen($metas['description'])?></span></td>
                    <td class="fbshow" style="display:none"><textarea name="facebook_description" rows="7"><?=$metas['facebook_description']?></textarea><span class="count">count: <?=mb_strlen($metas['facebook_description'])?></span></td>
                    <td class="twshow" style="display:none"><textarea name="twitter_description" rows="7"><?=$metas['twitter_description']?></textarea><span class="count">count: <?=mb_strlen($metas['twitter_description'])?></span></td>
                    <td class="fbshow" style="display:none">
                        <a href="#" class="button stereo-upload" <?=$metas['facebook_image'] ? 'style="display:none;"':''?>>Upload image</a>
                        <img style="max-width:100px; max-height:100px;<?=$metas['facebook_image']?'':'display:none;'?>" src="<?=$metas['facebook_image']?>">
                        <a href="#" class="stereo-remove-fb-image" <?=$metas['facebook_image'] ? '': 'style="display:none;"'?>>Remove image</a>
                        <input type="hidden" name="facebook_image" value="">
                    </td>
                    <?php if (defined('WPSEO_VERSION')) : ?>
                    <td class="twshow" style="display:none">
                        <a href="#" class="button stereo-upload" <?=$metas['twitter_image'] ? 'style="display:none;"':''?>>Upload image</a>
                        <img style="max-width:100px; max-height:100px;<?=$metas['twitter_image']?'':'display:none;'?>" src="<?=$metas['twitter_image']?>">
                        <a href="#" class="stereo-remove-fb-image" <?=$metas['twitter_image'] ? '': 'style="display:none;"'?>>Remove image</a>
                        <input type="hidden" name="twitter_image" value="">
                    </td>
                    <?php endif; ?>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    //on #fb-select change, show/hide .fbshow
    jQuery('#fb-select').on('change', function() {
        if (jQuery(this).prop('checked') === true) {
            jQuery('.fbshow').show();
        } else {
            jQuery('.fbshow').hide();
        }
    });
    jQuery('#tw-select').on('change', function() {
        if (jQuery(this).prop('checked') === true) {
            jQuery('.twshow').show();
        } else {
            jQuery('.twshow').hide();
        }
    });

</script>