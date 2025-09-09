import { registerBlockType } from '@wordpress/blocks';
import { InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl, Button } from '@wordpress/components';
import { Fragment } from '@wordpress/element';

registerBlockType('eventos/menu-cabecalho', {
	edit: ({ attributes, setAttributes }) => {
		const { links, align } = attributes;

		const updateLink = (index, key, value) => {
			const newLinks = [...links];
			newLinks[index][key] = value;
			setAttributes({ links: newLinks });
		};

		const addLink = () => {
			setAttributes({ links: [...links, { label: 'Novo Link', url: '#' }] });
		};

		const removeLink = (index) => {
			const newLinks = [...links];
			newLinks.splice(index, 1);
			setAttributes({ links: newLinks });
		};

		return (
			<Fragment>
				<InspectorControls>
					<PanelBody title="Alinhamento">
						<select
							value={align}
							onChange={(e) => setAttributes({ align: e.target.value })}
						>
							<option value="left">Esquerda</option>
							<option value="center">Centro</option>
							<option value="right">Direita</option>
						</select>
					</PanelBody>
				</InspectorControls>

				<div style={{ display: 'flex', justifyContent: align === 'left' ? 'flex-start' : align === 'center' ? 'center' : 'flex-end', padding: '1rem', border: '1px dashed #ccc' }}>
					{links.map((link, i) => (
						<div key={i} style={{ marginRight: '1rem' }}>
							<TextControl
								value={link.label}
								onChange={(val) => updateLink(i, 'label', val)}
								placeholder="Label"
							/>
							<TextControl
								value={link.url}
								onChange={(val) => updateLink(i, 'url', val)}
								placeholder="URL"
							/>
							<Button isDestructive onClick={() => removeLink(i)}>Remover</Button>
						</div>
					))}
					<Button isPrimary onClick={addLink}>Adicionar Link</Button>
				</div>
			</Fragment>
		);
	},
	save: () => null
});
