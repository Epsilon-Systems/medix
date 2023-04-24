<?php
/**
 * @package			No Boss Extensions
 * @subpackage  	No Boss Library
 * @author			No Boss Technology <contact@nobosstechnology.com>
 * @copyright		Copyright (C) 2022 No Boss Technology. All rights reserved.
 * @license			GNU Lesser General Public License version 3 or later; see <https://www.gnu.org/licenses/lgpl-3.0.en.html>
 */

// No direct access
defined('_JEXEC') or die('Restricted access');
//JHtml::_('behavior.tooltip');
jimport('noboss.util.url');
// echo '<pre>';
// var_dump($this->licenseInfoData);
// exit;

// Carregado no site demo: exibe mensagem e nao exibe dados
if (strpos(JURI::root(), 'nobossextensions.com/demos') !== false) {
    ?>
    <div data-id="license-alert-message" class="feedback-notice feedback-notice--info ">
    <span class="feedback-notice__icon fa fa-info-circle"></span>
    <div class="feedback-notice__content">
        <h4 class="feedback-notice__title">Demo website</h4>
        <p class="feedback-notice__message" data-id="license-alert-message-text">
            License data is not displayed because you are in demo mode.
        </p>
    </div>
</div>
    <?php
    return;
}

// Obtem configuracoes globais
$config     = JFactory::getConfig();
// Obtem offset das configuracoes globais
$dateOffSet = $config->get('offset', 'America/Sao_Paulo');

$linkClientArea = NoBossUtilUrl::getUrlNbExtensions()."/customer-area/";
?>

<section class="license-section nb-lg-8 nb-md-10 nb-sm-12 nb-xs-12">
    <?php
    // Defindas mensagens para exibir no topo da aba de notificacoes
    if ((isset($this->licenseInfoData->notices_tab_license)) && (count($this->licenseInfoData->notices_tab_license) > 0)){
        // Percorre todas mensagens
        foreach ($this->licenseInfoData->notices_tab_license as $message) {
            if (empty($message->icon)){
                $message->icon = 'fa-info-circle';
            }
            ?>
            <div data-id='license-alert-message' class='feedback-notice feedback-notice--<?php echo $message->type; ?> <?php if(!empty($message->class)){ echo $message->class;} ?>'>
                <span class="feedback-notice__icon fa <?php echo $message->icon; ?>"></span>
                <div class="feedback-notice__content">
                    <?php if (!empty($message->title)){?>
                        <h4 class="feedback-notice__title"><?php echo $message->title; ?></h4>
                    <?php } ?>
                    <p class="feedback-notice__message" data-id='license-alert-message-text'>
                        <?php echo $message->message; ?>
                    </p>
                </div>
            </div>
            <?php
        }
    }

    // Exibe informacoes da licenca
    ?>
    <div class="license-table">
        <h3 class="license-table__title">
            <?php echo JText::_('LIB_NOBOSS_FIELD_NOBOSSLICENSE_CONTENT_TAB_INFO_INTRO_TITLE'); ?> 
        </h3>

        <div class="license-infos">
            <div class="license-infos__item">
                <div class="license-infos__label">
                    <?php echo JText::_("LIB_NOBOSS_FIELD_NOBOSSLICENSE_CONTENT_TAB_INFO_RESPONSIBLE_LABEL"); ?>
                </div>
                <div class="license-infos__text">
                    <?php echo $this->licenseInfoData->responsible_name; ?>
                </div>
            </div>
            <div class="license-infos__item">
                <div class="license-infos__label">
                    <?php echo JText::_("LIB_NOBOSS_FIELD_NOBOSSLICENSE_CONTENT_TAB_INFO_SUPPORT_UPDATES_EXPIRATION_DATE_LABEL"); ?>
                </div>
                <div class="license-infos__text">
                    <?php 
                    // Obtem objeto de data e hora atual
                    $dateLicenseObj = JFactory::getDate($this->licenseInfoData->support_updates_expiration, $dateOffSet);
                    // Converte a data para o formato definido para o idioma do usuario
                    $dateExpireUpdates = $dateLicenseObj->format(JText::_("NOBOSS_EXTENSIONS_GLOBAL_DATE_FORMAT"));

                    // Licenca esta com suporte de atualizacoes ativo
                    if($this->licenseInfoData->inside_support_updates_expiration){
                        echo $dateExpireUpdates;
                    }
                    // Licenca esta com suporte de atualizacoes expirado
                    else{
                        // Exibe mensagem que esta sem suporte com link para entrar em contato para regularizar
                        echo JText::sprintf("LIB_NOBOSS_FIELD_NOBOSSLICENSE_CONTENT_TAB_INFO_SUPPORT_UPDATE_INVALID_PERIOD",$dateExpireUpdates);
                    }
                    ?>
                </div>
            </div>
            <div class="license-infos__item">
                <div class="license-infos__label">
                    <?php echo JText::_("LIB_NOBOSS_FIELD_NOBOSSLICENSE_CONTENT_TAB_INFO_SUPPORT_TECHNICAL_EXPIRATION_DATE_LABEL"); ?>
                </div>
                <div class="license-infos__text">
                    <?php 
                        // Obtem objeto de data e hora atual
                        $dateLicenseObj = JFactory::getDate($this->licenseInfoData->support_technical_expiration, $dateOffSet);
                        // Converte a data para o formato definido para o idioma do usuario
                        $dateExpireTechnical = $dateLicenseObj->format(JText::_("NOBOSS_EXTENSIONS_GLOBAL_DATE_FORMAT"));

                        // Licenca esta com suporte tecnico ativo
                        if($this->licenseInfoData->inside_support_technical_expiration){
                            echo $dateExpireTechnical;

                            // Link para pagina de pedido de ajuda
                            $linkSupport = $linkClientArea.'need-help/index.php?cod-license='.$this->licenseInfoData->id_license;

                            // Link para formulario de pedido de suporte tecnico
                            //$linkSupport = $linkClientArea.'request-technical-support/index.php?cod-license='.$this->licenseInfoData->id_license;


                            // Exibe link para solicitar contato
                            ?>
                            <a target="_blank" href="<?php echo $linkSupport; ?>">
                                <?php echo JText::_('LIB_NOBOSS_FIELD_NOBOSSLICENSE_CONTENT_TAB_INFO_SUPPORT_TECHNICAL_CONTACT_BUTTON'); ?>
                            </a>
                            <?php
                        }
                        // Licenca esta com suporte ativo expirado
                        else{
                            // Exibe mensagem que esta sem suporte com link para entrar em contato para regularizar
                            echo JText::sprintf("LIB_NOBOSS_FIELD_NOBOSSLICENSE_CONTENT_TAB_INFO_SUPPORT_TECHNICAL_INVALID_PERIOD", $dateExpireTechnical);
                        }
                    ?>
                </div>
            </div>
            <div class="license-infos__item">
                <div class="license-infos__label">
                    <?php echo JText::_("LIB_NOBOSS_FIELD_NOBOSSLICENSE_CONTENT_TAB_INFO_LICENSE_NUMBER_LABEL"); ?>
                </div>
                <div class="license-infos__text">
                    <?php echo $this->licenseInfoData->id_license; ?>
                </div>
            </div>
            <div class="license-infos__item">
                <div class="license-infos__label">
                    <?php echo JText::_("LIB_NOBOSS_FIELD_NOBOSSLICENSE_CONTENT_TAB_INFO_EXTENSION_VERSION_LABEL"); ?>
                </div>
                <div class="license-infos__text">
                    <?php
                    // Exibe a versao da extensao
                    echo $this->licenseInfoData->extension_version; 

                    // Licenca esta com suporte de atualizacoes ativo e usuario tem permissao de atualizacao de extensoes no joomla
                    if (($this->licenseInfoData->inside_support_updates_expiration) && (JFactory::getUser()->authorise('core.manage', 'com_installer'))){
                        // Exibe link que permite usuario reinstalar extensao
                        ?>
                        <a href="#" data-id="btn-reinstall" style="font-weight: 400;"><?php echo JText::_("LIB_NOBOSS_FIELD_NOBOSSLICENSE_REINSTALL_LINK"); ?></a>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="nb-license-copyright">
            <?php // copyright ?> 
            <?php echo JText::_("LIB_NOBOSS_FIELD_NOBOSSLICENSE_CONTENT_TAB_INFO_COPYRIGHT_VALUE"); ?>
            &nbsp;|&nbsp;
            <?php // Link para area do cliente ?>
            <?php echo JText::sprintf("LIB_NOBOSS_FIELD_NOBOSSLICENSE_CONTENT_TAB_INFO_CLIENT_AREA", $linkClientArea.'my-requests'); ?>
        </div>
    </div>
</section>
