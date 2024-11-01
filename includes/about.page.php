<div class="wrap" style="background: #ffffff;">
	<img src="<?php echo ZAMEN_PLUGIN_URL . '/img/banner.jpg'; ?>" style="width:100%;"/>
	<div style="margin:15px;">
		<table style="border: 0;width: 100%">
			<tr>
				<td style="max-width:400px;vertical-align: top;padding: 10px;text-align:justify;font-size:110%">
					<?php _e( 'Zamen is a mobile application that combines the best websites that feature the quality of the content. Zamen brings new audiences to your website who follows you passionately and love to read all the new content you offer. The existence of your content in Zamen will increase your followers on smart devices, so you combine your current visitors with new ones comes from Zamen, and sure this will enrich the Arabic content on smart devices and increases the interest in your website. Zamen plugin synchronize your blog and comments with Zamen mobile application, also provides you with statistics to know how your followers respond to your content.', 'zamen' ); ?>
				</td>

				<td style="min-width:200px;vertical-align: top;padding: 10px;text-align: center">
					<a class="button button-primary" href="http://partners.zamenapp.com/analytics/<?php echo $zamenOptions['namespace']; ?>?t=<?php echo $zamenOptions['access_key']; ?>" onclick="<?php echo $onClick; ?>" target="_blank"><?php _e( 'Show statistics', 'zamen' ); ?></a>

					<br/><br/>
					<form method="post">
						<table class="form-table">
							<tbody>
							<tr>
								<th scope="row"><label for="zamen_namespace"><?php _e( 'Namespace', 'zamen' ); ?></label></th>
								<td><input name="zamen_namespace" type="text" value="<?php echo $zamenOptions['namespace'] ?>" class="regular-text" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABHklEQVQ4EaVTO26DQBD1ohQWaS2lg9JybZ+AK7hNwx2oIoVf4UPQ0Lj1FdKktevIpel8AKNUkDcWMxpgSaIEaTVv3sx7uztiTdu2s/98DywOw3Dued4Who/M2aIx5lZV1aEsy0+qiwHELyi+Ytl0PQ69SxAxkWIA4RMRTdNsKE59juMcuZd6xIAFeZ6fGCdJ8kY4y7KAuTRNGd7jyEBXsdOPE3a0QGPsniOnnYMO67LgSQN9T41F2QGrQRRFCwyzoIF2qyBuKKbcOgPXdVeY9rMWgNsjf9ccYesJhk3f5dYT1HX9gR0LLQR30TnjkUEcx2uIuS4RnI+aj6sJR0AM8AaumPaM/rRehyWhXqbFAA9kh3/8/NvHxAYGAsZ/il8IalkCLBfNVAAAAABJRU5ErkJggg==&quot;); background-attachment: scroll; background-size: 16px 18px; background-position: 0% 50%; background-repeat: no-repeat;"></td>
							</tr>
							<tr>
								<th scope="row">
									<label for="zamen_access_key"><?php _e( 'Access key', 'zamen' ); ?></label>
								</th>
								<td><input name="zamen_access_key" type="text" value="<?php echo $zamenOptions['access_key'] ?>" class="regular-text" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABHklEQVQ4EaVTO26DQBD1ohQWaS2lg9JybZ+AK7hNwx2oIoVf4UPQ0Lj1FdKktevIpel8AKNUkDcWMxpgSaIEaTVv3sx7uztiTdu2s/98DywOw3Dued4Who/M2aIx5lZV1aEsy0+qiwHELyi+Ytl0PQ69SxAxkWIA4RMRTdNsKE59juMcuZd6xIAFeZ6fGCdJ8kY4y7KAuTRNGd7jyEBXsdOPE3a0QGPsniOnnYMO67LgSQN9T41F2QGrQRRFCwyzoIF2qyBuKKbcOgPXdVeY9rMWgNsjf9ccYesJhk3f5dYT1HX9gR0LLQR30TnjkUEcx2uIuS4RnI+aj6sJR0AM8AaumPaM/rRehyWhXqbFAA9kh3/8/NvHxAYGAsZ/il8IalkCLBfNVAAAAABJRU5ErkJggg==&quot;); background-attachment: scroll; background-size: 16px 18px; background-position: 0% 50%; background-repeat: no-repeat;"></td>
							</tr>
							</tbody>
						</table>
						<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e( 'Save changes', 'zamen' ); ?>"></p>
					</form>
					<div>
						<small>*<?php _e( 'Please contact us at info@zamenapp.com to get your namespace and access token!', 'zamen' ); ?>
							<small>
					</div>
				</td>
			</tr>
		</table>

	</div>
</div>
