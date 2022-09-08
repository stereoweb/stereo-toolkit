<div class="wrap">
    <h1 class="wp-heading-inline">
        SEO Listing
    </h1>

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
                    <th scope="col" id="title" class="manage-column column-title column-primary">Title</th>
                    <th scope="col" class="manage-column">Slug</th>
                    <th scope="col" class="manage-column">Title SEO</th>
                    <th scope="col" class="manage-column">Meta description</th>
                    <th scope="col" class="manage-column">Facebook title</th>
                    <th scope="col" class="manage-column">Facebook description</th>
                    <th scope="col" class="manage-column">Facebook image</th>
                    <th scope="col" class="manage-column">Twitter title</th>
                    <th scope="col" class="manage-column">Twitter description</th>
                    <th scope="col" class="manage-column">Twitter image</th>
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
                    <td><input type="text" name="meta_title" value="<?=$metas['title']?>"></td>
                    <td><textarea name="meta_description"><?=$metas['description']?></textarea></td>
                    <td><input type="text" name="facebook_title" value="<?=$metas['facebook_title']?>"></td>
                    <td><textarea name="facebook_description"><?=$metas['facebook_description']?></textarea></td>
                    <td>
                        <a href="#" class="button stereo-upload" <?=$metas['facebook_image'] ? 'style="display:none;"':''?>>Upload image</a>
                        <img style="max-width:100px; max-height:100px;<?=$metas['facebook_image']?'':'display:none;'?>" src="<?=$metas['facebook_image']?>">
                        <a href="#" class="stereo-remove-fb-image" <?=$metas['facebook_image'] ? '': 'style="display:none;"'?>>Remove image</a>
                        <input type="hidden" name="facebook_image" value="">
                    </td>
                    <td><input type="text" name="twitter_title" value="<?=$metas['twitter_title']?>"></td>
                    <td><textarea name="twitter_description"><?=$metas['twitter_description']?></textarea></td>
                    <td>
                        <a href="#" class="button stereo-upload" <?=$metas['twitter_image'] ? 'style="display:none;"':''?>>Upload image</a>
                        <img style="max-width:100px; max-height:100px;<?=$metas['twitter_image']?'':'display:none;'?>" src="<?=$metas['twitter_image']?>">
                        <a href="#" class="stereo-remove-fb-image" <?=$metas['twitter_image'] ? '': 'style="display:none;"'?>>Remove image</a>
                        <input type="hidden" name="twitter_image" value="">
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>