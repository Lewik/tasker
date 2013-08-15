Ext.application({
	name: 'HelloExt',
	launch: function () {
		Ext.create('Ext.panel.Panel', {
			renderTo: Ext.getBody(),
			title: 'Tasker',
			type: 'vbox',
			align: 'stretch',
			pack: 'start',
			items: [
				{
					xtype: 'panel',
					header: false,
					title: 'Задача 1',
					bodyPadding: 5,
					rbar: [
						{
							xtype: 'button',
							text: 'Развернуть'
						}
					],
					items: [
						{
							xtype: 'tbtext',
							text: 'Текст задачи 1'
						}/*,
						{
							xtype: 'textarea',
							value: 'Текст задачи 1'
						}*/
					]
				},
				{
					xtype: 'panel',
					header: false,
					title: 'Задача 2',
					bodyPadding: 5,
					height: 200,
					rbar: [
						{
							xtype: 'button',
							text: 'Свернуть'
						},
						{
							xtype: 'button',
							text: 'Сохранить'
						},
						{
							xtype: 'button',
							text: 'Удалить'
						},
						{
							xtype: 'button',
							text: 'Теги',
							menu: {
								xtype: 'menu',
								items: [
									{
										text: 'тег1',
										xtype: 'menucheckitem'
									},
									{
										text: 'тег2',
										xtype: 'menucheckitem'
									},
									{
										text: 'тег3',
										xtype: 'menucheckitem'
									}
								]
							}
						}
					],
					items: [
						 {
						 xtype: 'textarea',
						 value: 'Текст задачи 2',
							 width: '100%'
						 }
					]
				}
			]
		});


	}
});