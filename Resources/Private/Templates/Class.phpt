{namespace cp=Tx_Classparser_ViewHelpers}<?php
{classObject.docComment}
<f:if condition="{classObject.modifier}"><f:for each="{classObject.modifierNames}" as="modifierName">{modifierName} </f:for></f:if>class {classObject.name}<cp:class classObject="{classObject}"  renderElement="parentClass" /> <cp:class classObject="{classObject}"  renderElement="interfaces" />{
<f:for each="{classObject.constants}" as="constant">
	/**
	 *<f:for each="{constant.docComment.getDescriptionLines}" as="descriptionLine">
	 * {descriptionLine}</f:for>
	 *<f:for each="{constant.tags}" as="tag">
	 * {tag}</f:for>
	 */
	const {constant.name} = {constant.value};
</f:for><f:for each="{classObject.properties}" as="property"><f:if condition="{property.precedingBlock}">
	<cp:format.removeMultipleNewlines>{property.precedingBlock}</cp:format.removeMultipleNewlines>
	</f:if>
	/**<f:for each="{property.descriptionLines}" as="descriptionLine">
	 * {descriptionLine}</f:for>
	 *<f:for each="{property.annotations}" as="annotation">
	 * @{annotation}</f:for>
	 */
	<f:for each="{property.modifierNames}" as="modifierName">{modifierName} </f:for>${property.name}<f:if condition="{property.hasValue}"><f:then> = {property.value}</f:then><f:else><f:if condition="{property.hasDefaultValue}"> = {property.default}</f:if></f:else></f:if>;
</f:for><f:for each="{classObject.methods}" as="method"><f:if condition="{method.precedingBlock}">
	<cp:format.removeMultipleNewlines>{method.precedingBlock}</cp:format.removeMultipleNewlines>
	</f:if>
	/**<f:for each="{method.descriptionLines}" as="descriptionLine">
	 * {descriptionLine}</f:for>
	 *<f:for each="{method.annotations}" as="annotation">
	 * @{annotation}</f:for>
	 */
	<f:for each="{method.modifierNames}" as="modifierName">{modifierName} </f:for>function {method.name}(<cp:method methodObject="{method}"  renderElement="parameter" />) <![CDATA[{]]>
{method.body}
	<![CDATA[}]]>
</f:for>
}
{classObject.appendedBlock}?>