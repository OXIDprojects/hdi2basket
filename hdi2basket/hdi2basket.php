<?php
/**
* HDI 2Basket
* for Oxid eShop 4.5.0
*
*  This program is free software: you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation, either version 3 of the License, or
*  (at your option) any later version.
*
*  This program is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  You should have received a copy of the GNU General Public License
*  along with this program.  If not, see <http://www.gnu.org/licenses/>.
*
*  @author HEINER DIRECT GmbH & Co.KG
*  @author Rafael Dabrowski
*  @link http://www-heiner-direct.com
*
*  @copyright HEINER DIRECT GmbH & Co. KG 2011
*  @license GPLv3
*
*/

class hdi2basket extends hdi2basket_parent
{
	public function tobasket()
	{
		$oConfig=$this->getConfig();
		$multiple = $oConfig->getParameter("multiple");
		if($multiple){
			$this->toBasketMultiple();
		}
		else{
			$this->toBasketSingle();
		}
			
	}
	
	public function getOxidFromArtnum($artnum)
	{
		$sOXID = null; 
			$rs = oxDb::getDB(true)->execute("select oxid from oxarticles where oxartnum = '".mysql_real_escape_string($artnum)."' AND oxactive='1' AND oxvarcount = 0 LIMIT 1");
			if ($rs != false && $rs->recordCount() > 0)
			{
				$sOXID=$rs->fields['oxid'];
			}
			else{
				$sOXID = null; 
			}
			
			return $sOXID;
	
	}
	public function toBasketSingle()
	{
		$oConfig=$this->getConfig();
		$fast=$oConfig->getParameter( 'fast');
		$am=$oConfig->getParameter( 'am');
		if ($fast)
		{
			$NoArticle=false;
			$artnum = $oConfig->getParameter("artnum");
			$rs = oxDb::getDB(true)->execute("select oxid from oxarticles where oxartnum = '".mysql_real_escape_string($artnum)."' AND oxactive='1' AND oxvarcount=0 LIMIT 1");
			if ($rs != false && $rs->recordCount() > 0)
			{
				$sOXID=$rs->fields['oxid'];
				if ($sOXID)
				{
					$oArticle = oxNew( "oxarticle");
					$oArticle->load($sOXID);
				}
				else
				{
					$NoArticle = true;
				}
			}
			else
			{
				$NoArticle =true;
			}
			if ($NoArticle)
			{
				//Show user a failure message
				$oEx = oxNew( 'oxNoArticleException' );
				$oLang = oxLang::getInstance();
				$oEx->setMessage( sprintf($oLang->translateString( 'EXCEPTION_ARTICLE_ARTICELDOESNOTEXIST', $oLang->getBaseLanguage() ), $artnum) );
				oxUtilsView::getInstance()->addErrorToDisplay( $oEx );
				$class=$oConfig->getParameter("cl");
				oxUtils::getInstance()->redirect( oxConfig::getInstance()->getShopHomeURL() .'cl=basket', false, 302 );
			}
			else
			{
				//If article has select lists and/or variants redirect to detail page for further selections...
				$redirect=false;
				if ($oArticle->hasMdVariants())
				{
						
					$oEx = oxNew( 'oxNoArticleException' );
					$oLang = oxLang::getInstance();
					$oEx->setMessage( "Bitte wählen Sie eine Variante." );
					oxUtilsView::getInstance()->addErrorToDisplay( $oEx );
					$oxUtils=oxUtils::getInstance();
					if ( $oxUtils->seoIsActive() )
					{
						$oxdetaillink = oxSeoEncoderArticle::getInstance()->getArticleUrl( $oArticle);
					}
					else
					{
						$oxdetaillink = $oArticle->getStdLink();
					}
					$oxUtils->redirect( $oxdetaillink, false, 302 );
					$redirect=true;
				}
			}
		}
		parent::tobasket($sOXID,$am);
	}

	public function toBasketMultiple()
	{
		$oConfig=$this->getConfig();
		$am=$oConfig->getParameter('am');
		$NoArticle=false;
		$ids = null; 
		$i= 0;
		$fast=$oConfig->getParameter( 'fast');
		if($fast){
			$arts = $ids = $oConfig->getParameter("artnum");
			$s = 0; 
			foreach($arts as $art)
			{
				$ids[$s] = $this->getOxidFromArtnum($art);
				$s++;
			}
		}else
		{
			$ids = $oConfig->getParameter("id");
		}
			foreach($ids as $id)
			{
				if($id != "" && $am[$i] != ""){
					
					parent::tobasket($id,$am[$i]);
				}
				$i++;
			}
	}
}