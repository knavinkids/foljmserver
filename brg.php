<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *                                   ATTENTION!
 * If you see this message in your browser (Internet Explorer, Mozilla Firefox, Google Chrome, etc.)
 * this means that PHP is not properly installed on your web server. Please refer to the PHP manual
 * for more details: http://php.net/manual/install.php 
 *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 */

    include_once dirname(__FILE__) . '/components/startup.php';
    include_once dirname(__FILE__) . '/components/application.php';
    include_once dirname(__FILE__) . '/' . 'authorization.php';


    include_once dirname(__FILE__) . '/' . 'database_engine/mysql_engine.php';
    include_once dirname(__FILE__) . '/' . 'components/page/page_includes.php';

    function GetConnectionOptions()
    {
        $result = GetGlobalConnectionOptions();
        $result['client_encoding'] = 'utf8';
        GetApplication()->GetUserAuthentication()->applyIdentityToConnectionOptions($result);
        return $result;
    }

    
    
    
    
    // OnBeforePageExecute event handler
    
    
    
    class brg_brggaleriPage extends DetailPage
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Brggaleri');
            $this->SetMenuLabel('Brggaleri');
            $this->SetHeader(GetPagesHeader());
            $this->SetFooter(GetPagesFooter());
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brggaleri`');
            $this->dataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new IntegerField('idbarang', true),
                    new StringField('namafile'),
                    new DateTimeField('tanggal'),
                    new StringField('tipefile'),
                    new IntegerField('sizefile'),
                    new BlobField('filex')
                )
            );
            $this->dataset->AddLookupField('idbarang', 'brg', new IntegerField('id'), new IntegerField('idgol', false, false, false, false, 'idbarang_idgol', 'idbarang_idgol_brg'), 'idbarang_idgol_brg');
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function CreatePageNavigator()
        {
            $result = new CompositePageNavigator($this);
            
            $partitionNavigator = new PageNavigator('pnav', $this, $this->dataset);
            $partitionNavigator->SetRowsPerPage(20);
            $result->AddPageNavigator($partitionNavigator);
            
            return $result;
        }
    
        protected function CreateRssGenerator()
        {
            return null;
        }
    
        protected function setupCharts()
        {
    
        }
    
        protected function getFiltersColumns()
        {
            return array(
                new FilterColumn($this->dataset, 'id', 'id', 'Id'),
                new FilterColumn($this->dataset, 'idbarang', 'idbarang_idgol', 'Idbarang'),
                new FilterColumn($this->dataset, 'namafile', 'namafile', 'Namafile'),
                new FilterColumn($this->dataset, 'tanggal', 'tanggal', 'Tanggal'),
                new FilterColumn($this->dataset, 'tipefile', 'tipefile', 'Tipefile'),
                new FilterColumn($this->dataset, 'sizefile', 'sizefile', 'Sizefile'),
                new FilterColumn($this->dataset, 'filex', 'filex', 'Filex')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['id'])
                ->addColumn($columns['idbarang'])
                ->addColumn($columns['namafile'])
                ->addColumn($columns['tanggal'])
                ->addColumn($columns['tipefile'])
                ->addColumn($columns['sizefile'])
                ->addColumn($columns['filex']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('idbarang')
                ->setOptionsFor('tanggal')
                ->setOptionsFor('filex');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new TextEdit('id_edit');
            
            $filterBuilder->addColumn(
                $columns['id'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('idbarang_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_brg_brggaleri_idbarang_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('idbarang', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_brg_brggaleri_idbarang_search');
            
            $filterBuilder->addColumn(
                $columns['idbarang'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('namafile');
            
            $filterBuilder->addColumn(
                $columns['namafile'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DateTimeEdit('tanggal_edit', false, 'dd/MM/yy HH:mm');
            
            $filterBuilder->addColumn(
                $columns['tanggal'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::DATE_EQUALS => $main_editor,
                    FilterConditionOperator::DATE_DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::TODAY => null,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('tipefile_edit');
            $main_editor->SetMaxLength(100);
            
            $filterBuilder->addColumn(
                $columns['tipefile'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('sizefile_edit');
            
            $filterBuilder->addColumn(
                $columns['sizefile'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('filex');
            
            $filterBuilder->addColumn(
                $columns['filex'],
                array(
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
        }
    
        protected function AddOperationsColumns(Grid $grid)
        {
            $actions = $grid->getActions();
            $actions->setCaption($this->GetLocalizerCaptions()->GetMessageString('Actions'));
            $actions->setPosition(ActionList::POSITION_LEFT);
            
            if ($this->GetSecurityInfo()->HasViewGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('View'), OPERATION_VIEW, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
            
            if ($this->GetSecurityInfo()->HasEditGrant())
            {
                $operation = new AjaxOperation(OPERATION_EDIT,
                    $this->GetLocalizerCaptions()->GetMessageString('Edit'),
                    $this->GetLocalizerCaptions()->GetMessageString('Edit'), $this->dataset,
                    $this->GetGridEditHandler(), $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowEditButtonHandler', $this);
            }
            
            if ($this->GetSecurityInfo()->HasDeleteGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Delete'), OPERATION_DELETE, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowDeleteButtonHandler', $this);
                $operation->SetAdditionalAttribute('data-modal-operation', 'delete');
                $operation->SetAdditionalAttribute('data-delete-handler-name', $this->GetModalGridDeleteHandler());
            }
            
            if ($this->GetSecurityInfo()->HasAddGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Copy'), OPERATION_COPY, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
        }
    
        protected function AddFieldColumns(Grid $grid, $withDetails = true)
        {
            //
            // View column for id field
            //
            $column = new NumberViewColumn('id', 'id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for idgol field
            //
            $column = new NumberViewColumn('idbarang', 'idbarang_idgol', 'Idbarang', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for namafile field
            //
            $column = new TextViewColumn('namafile', 'namafile', 'Namafile', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for tanggal field
            //
            $column = new DateTimeViewColumn('tanggal', 'tanggal', 'Tanggal', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('dd/MM/yy HH:mm');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for tipefile field
            //
            $column = new TextViewColumn('tipefile', 'tipefile', 'Tipefile', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for sizefile field
            //
            $column = new NumberViewColumn('sizefile', 'sizefile', 'Sizefile', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for filex field
            //
            $column = new DownloadDataColumn('filex', 'filex', 'Filex', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for id field
            //
            $column = new NumberViewColumn('id', 'id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for idgol field
            //
            $column = new NumberViewColumn('idbarang', 'idbarang_idgol', 'Idbarang', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for namafile field
            //
            $column = new TextViewColumn('namafile', 'namafile', 'Namafile', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for tanggal field
            //
            $column = new DateTimeViewColumn('tanggal', 'tanggal', 'Tanggal', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('dd/MM/yy HH:mm');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for tipefile field
            //
            $column = new TextViewColumn('tipefile', 'tipefile', 'Tipefile', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for sizefile field
            //
            $column = new NumberViewColumn('sizefile', 'sizefile', 'Sizefile', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for filex field
            //
            $column = new DownloadDataColumn('filex', 'filex', 'Filex', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for idbarang field
            //
            $editor = new DynamicCombobox('idbarang_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('idgol', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Idbarang', 'idbarang', 'idbarang_idgol', 'edit_brg_brggaleri_idbarang_search', $editor, $this->dataset, $lookupDataset, 'id', 'idgol', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for namafile field
            //
            $editor = new TextAreaEdit('namafile_edit', 50, 8);
            $editColumn = new CustomEditColumn('Namafile', 'namafile', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for tanggal field
            //
            $editor = new DateTimeEdit('tanggal_edit', false, 'dd/MM/yy HH:mm');
            $editColumn = new CustomEditColumn('Tanggal', 'tanggal', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for tipefile field
            //
            $editor = new TextEdit('tipefile_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Tipefile', 'tipefile', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for sizefile field
            //
            $editor = new TextEdit('sizefile_edit');
            $editColumn = new CustomEditColumn('Sizefile', 'sizefile', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for filex field
            //
            $editor = new ImageUploader('filex_edit');
            $editor->SetShowImage(false);
            $editColumn = new FileUploadingColumn('Filex', 'filex', $editor, $this->dataset, false, false, 'brg_brggaleri_filex_handler_edit');
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for idbarang field
            //
            $editor = new DynamicCombobox('idbarang_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('idgol', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Idbarang', 'idbarang', 'idbarang_idgol', 'multi_edit_brg_brggaleri_idbarang_search', $editor, $this->dataset, $lookupDataset, 'id', 'idgol', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for namafile field
            //
            $editor = new TextAreaEdit('namafile_edit', 50, 8);
            $editColumn = new CustomEditColumn('Namafile', 'namafile', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for tanggal field
            //
            $editor = new DateTimeEdit('tanggal_edit', false, 'dd/MM/yy HH:mm');
            $editColumn = new CustomEditColumn('Tanggal', 'tanggal', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for tipefile field
            //
            $editor = new TextEdit('tipefile_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Tipefile', 'tipefile', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for sizefile field
            //
            $editor = new TextEdit('sizefile_edit');
            $editColumn = new CustomEditColumn('Sizefile', 'sizefile', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for filex field
            //
            $editor = new ImageUploader('filex_edit');
            $editor->SetShowImage(false);
            $editColumn = new FileUploadingColumn('Filex', 'filex', $editor, $this->dataset, false, false, 'brg_brggaleri_filex_handler_multi_edit');
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for idbarang field
            //
            $editor = new DynamicCombobox('idbarang_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('idgol', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Idbarang', 'idbarang', 'idbarang_idgol', 'insert_brg_brggaleri_idbarang_search', $editor, $this->dataset, $lookupDataset, 'id', 'idgol', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for namafile field
            //
            $editor = new TextAreaEdit('namafile_edit', 50, 8);
            $editColumn = new CustomEditColumn('Namafile', 'namafile', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for tanggal field
            //
            $editor = new DateTimeEdit('tanggal_edit', false, 'dd/MM/yy HH:mm');
            $editColumn = new CustomEditColumn('Tanggal', 'tanggal', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for tipefile field
            //
            $editor = new TextEdit('tipefile_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Tipefile', 'tipefile', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for sizefile field
            //
            $editor = new TextEdit('sizefile_edit');
            $editColumn = new CustomEditColumn('Sizefile', 'sizefile', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for filex field
            //
            $editor = new ImageUploader('filex_edit');
            $editor->SetShowImage(false);
            $editColumn = new FileUploadingColumn('Filex', 'filex', $editor, $this->dataset, false, false, 'brg_brggaleri_filex_handler_insert');
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            $grid->SetShowAddButton(true && $this->GetSecurityInfo()->HasAddGrant());
        }
    
        private function AddMultiUploadColumn(Grid $grid)
        {
    
        }
    
        protected function AddPrintColumns(Grid $grid)
        {
            //
            // View column for id field
            //
            $column = new NumberViewColumn('id', 'id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for idgol field
            //
            $column = new NumberViewColumn('idbarang', 'idbarang_idgol', 'Idbarang', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for namafile field
            //
            $column = new TextViewColumn('namafile', 'namafile', 'Namafile', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for tanggal field
            //
            $column = new DateTimeViewColumn('tanggal', 'tanggal', 'Tanggal', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('dd/MM/yy HH:mm');
            $grid->AddPrintColumn($column);
            
            //
            // View column for tipefile field
            //
            $column = new TextViewColumn('tipefile', 'tipefile', 'Tipefile', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for sizefile field
            //
            $column = new NumberViewColumn('sizefile', 'sizefile', 'Sizefile', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddPrintColumn($column);
            
            //
            // View column for filex field
            //
            $column = new DownloadDataColumn('filex', 'filex', 'Filex', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for id field
            //
            $column = new NumberViewColumn('id', 'id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for idgol field
            //
            $column = new NumberViewColumn('idbarang', 'idbarang_idgol', 'Idbarang', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for namafile field
            //
            $column = new TextViewColumn('namafile', 'namafile', 'Namafile', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for tanggal field
            //
            $column = new DateTimeViewColumn('tanggal', 'tanggal', 'Tanggal', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('dd/MM/yy HH:mm');
            $grid->AddExportColumn($column);
            
            //
            // View column for tipefile field
            //
            $column = new TextViewColumn('tipefile', 'tipefile', 'Tipefile', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for sizefile field
            //
            $column = new NumberViewColumn('sizefile', 'sizefile', 'Sizefile', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddExportColumn($column);
            
            //
            // View column for filex field
            //
            $column = new DownloadDataColumn('filex', 'filex', 'Filex', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for idgol field
            //
            $column = new NumberViewColumn('idbarang', 'idbarang_idgol', 'Idbarang', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for namafile field
            //
            $column = new TextViewColumn('namafile', 'namafile', 'Namafile', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for tanggal field
            //
            $column = new DateTimeViewColumn('tanggal', 'tanggal', 'Tanggal', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('dd/MM/yy HH:mm');
            $grid->AddCompareColumn($column);
            
            //
            // View column for tipefile field
            //
            $column = new TextViewColumn('tipefile', 'tipefile', 'Tipefile', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for sizefile field
            //
            $column = new NumberViewColumn('sizefile', 'sizefile', 'Sizefile', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddCompareColumn($column);
            
            //
            // View column for filex field
            //
            $column = new DownloadDataColumn('filex', 'filex', 'Filex', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
        }
    
        private function AddCompareHeaderColumns(Grid $grid)
        {
    
        }
    
        public function GetPageDirection()
        {
            return null;
        }
    
        public function isFilterConditionRequired()
        {
            return false;
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetDisplaySetToNullCheckBox(false);
            $column->SetDisplaySetToDefaultCheckBox(false);
    		$column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
        
        public function GetEnableModalGridInsert() { return true; }
        public function GetEnableModalGridEdit() { return true; }
        
        protected function GetEnableModalGridDelete() { return true; }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset);
            if ($this->GetSecurityInfo()->HasDeleteGrant())
               $result->SetAllowDeleteSelected(true);
            else
               $result->SetAllowDeleteSelected(false);   
            
            ApplyCommonPageSettings($this, $result);
            
            $result->SetUseImagesForActions(true);
            $result->SetUseFixedHeader(false);
            $result->SetShowLineNumbers(true);
            $result->SetViewMode(ViewMode::TABLE);
            $result->setEnableRuntimeCustomization(true);
            $result->setAllowCompare(true);
            $this->AddCompareHeaderColumns($result);
            $this->AddCompareColumns($result);
            $result->setMultiEditAllowed($this->GetSecurityInfo()->HasEditGrant() && true);
            $result->setTableBordered(false);
            $result->setTableCondensed(false);
            
            $result->SetHighlightRowAtHover(true);
            $result->SetWidth('');
            $this->AddOperationsColumns($result);
            $this->AddFieldColumns($result);
            $this->AddSingleRecordViewColumns($result);
            $this->AddEditColumns($result);
            $this->AddMultiEditColumns($result);
            $this->AddInsertColumns($result);
            $this->AddPrintColumns($result);
            $this->AddExportColumns($result);
            $this->AddMultiUploadColumn($result);
    
    
            $this->SetShowPageList(true);
            $this->SetShowTopPageNavigator(true);
            $this->SetShowBottomPageNavigator(true);
            $this->setPrintListAvailable(true);
            $this->setPrintListRecordAvailable(false);
            $this->setPrintOneRecordAvailable(true);
            $this->setAllowPrintSelectedRecords(true);
            $this->setExportListAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportSelectedRecordsAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportListRecordAvailable(array());
            $this->setExportOneRecordAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
    
            return $result;
        }
     
        protected function setClientSideEvents(Grid $grid) {
    
        }
    
        protected function doRegisterHandlers() {
            $handler = new DownloadHTTPHandler($this->dataset, 'filex', 'filex_handler', '', '', true);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $handler = new DownloadHTTPHandler($this->dataset, 'filex', 'filex_handler', '', '', true);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $handler = new DownloadHTTPHandler($this->dataset, 'filex', 'filex_handler', '', '', true);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('idgol', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_brg_brggaleri_idbarang_search', 'id', 'idgol', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $handler = new ImageHTTPHandler($this->dataset, 'filex', 'brg_brggaleri_filex_handler_insert', new NullFilter());
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('idgol', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_brg_brggaleri_idbarang_search', 'id', 'idgol', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('idgol', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_brg_brggaleri_idbarang_search', 'id', 'idgol', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $handler = new DownloadHTTPHandler($this->dataset, 'filex', 'filex_handler', '', '', true);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('idgol', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_brg_brggaleri_idbarang_search', 'id', 'idgol', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $handler = new ImageHTTPHandler($this->dataset, 'filex', 'brg_brggaleri_filex_handler_edit', new NullFilter());
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('idgol', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_brg_brggaleri_idbarang_search', 'id', 'idgol', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $handler = new ImageHTTPHandler($this->dataset, 'filex', 'brg_brggaleri_filex_handler_multi_edit', new NullFilter());
            GetApplication()->RegisterHTTPHandler($handler);
        }
       
        protected function doCustomRenderColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderPrintColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderExportColumn($exportType, $fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomDrawRow($rowData, &$cellFontColor, &$cellFontSize, &$cellBgColor, &$cellItalicAttr, &$cellBoldAttr)
        {
    
        }
    
        protected function doExtendedCustomDrawRow($rowData, &$rowCellStyles, &$rowStyles, &$rowClasses, &$cellClasses)
        {
    
        }
    
        protected function doCustomRenderTotal($totalValue, $aggregate, $columnName, &$customText, &$handled)
        {
    
        }
    
        protected function doCustomDefaultValues(&$values, &$handled) 
        {
    
        }
    
        protected function doCustomCompareColumn($columnName, $valueA, $valueB, &$result)
        {
    
        }
    
        protected function doBeforeInsertRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doBeforeUpdateRecord($page, $oldRowData, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doBeforeDeleteRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterInsertRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterUpdateRecord($page, $oldRowData, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterDeleteRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doCustomHTMLHeader($page, &$customHtmlHeaderText)
        { 
    
        }
    
        protected function doGetCustomTemplate($type, $part, $mode, &$result, &$params)
        {
    
        }
    
        protected function doGetCustomExportOptions(Page $page, $exportType, $rowData, &$options)
        {
    
        }
    
        protected function doFileUpload($fieldName, $rowData, &$result, &$accept, $originalFileName, $originalFileExtension, $fileSize, $tempFileName)
        {
    
        }
    
        protected function doPrepareChart(Chart $chart)
        {
    
        }
    
        protected function doPrepareColumnFilter(ColumnFilter $columnFilter)
        {
    
        }
    
        protected function doPrepareFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
    
        }
    
        protected function doGetSelectionFilters(FixedKeysArray $columns, &$result)
        {
    
        }
    
        protected function doGetCustomFormLayout($mode, FixedKeysArray $columns, FormLayout $layout)
        {
    
        }
    
        protected function doGetCustomColumnGroup(FixedKeysArray $columns, ViewColumnGroup $columnGroup)
        {
    
        }
    
        protected function doPageLoaded()
        {
    
        }
    
        protected function doCalculateFields($rowData, $fieldName, &$value)
        {
    
        }
    
        protected function doGetCustomRecordPermissions(Page $page, &$usingCondition, $rowData, &$allowEdit, &$allowDelete, &$mergeWithDefault, &$handled)
        {
    
        }
    
        protected function doAddEnvironmentVariables(Page $page, &$variables)
        {
    
        }
    
    }
    
    
    
    
    // OnBeforePageExecute event handler
    
    
    
    class brg_brginfoPage extends DetailPage
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Brginfo');
            $this->SetMenuLabel('Brginfo');
            $this->SetHeader(GetPagesHeader());
            $this->SetFooter(GetPagesFooter());
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brginfo`');
            $this->dataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('deskripsi'),
                    new BlobField('gambar'),
                    new StringField('kd'),
                    new IntegerField('kg'),
                    new IntegerField('pembagi'),
                    new IntegerField('qtydos'),
                    new StringField('hdasar'),
                    new IntegerField('stokminimal'),
                    new StringField('supplier'),
                    new IntegerField('minimal'),
                    new IntegerField('stok'),
                    new StringField('rak')
                )
            );
            $this->dataset->AddLookupField('id', 'brg', new IntegerField('id'), new IntegerField('idgol', false, false, false, false, 'id_idgol', 'id_idgol_brg'), 'id_idgol_brg');
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function CreatePageNavigator()
        {
            $result = new CompositePageNavigator($this);
            
            $partitionNavigator = new PageNavigator('pnav', $this, $this->dataset);
            $partitionNavigator->SetRowsPerPage(20);
            $result->AddPageNavigator($partitionNavigator);
            
            return $result;
        }
    
        protected function CreateRssGenerator()
        {
            return null;
        }
    
        protected function setupCharts()
        {
    
        }
    
        protected function getFiltersColumns()
        {
            return array(
                new FilterColumn($this->dataset, 'id', 'id_idgol', 'Id'),
                new FilterColumn($this->dataset, 'deskripsi', 'deskripsi', 'Deskripsi'),
                new FilterColumn($this->dataset, 'gambar', 'gambar', 'Gambar'),
                new FilterColumn($this->dataset, 'kd', 'kd', 'Kd'),
                new FilterColumn($this->dataset, 'kg', 'kg', 'Kg'),
                new FilterColumn($this->dataset, 'pembagi', 'pembagi', 'Pembagi'),
                new FilterColumn($this->dataset, 'qtydos', 'qtydos', 'Qtydos'),
                new FilterColumn($this->dataset, 'hdasar', 'hdasar', 'Hdasar'),
                new FilterColumn($this->dataset, 'stokminimal', 'stokminimal', 'Stokminimal'),
                new FilterColumn($this->dataset, 'supplier', 'supplier', 'Supplier'),
                new FilterColumn($this->dataset, 'minimal', 'minimal', 'Minimal'),
                new FilterColumn($this->dataset, 'stok', 'stok', 'Stok'),
                new FilterColumn($this->dataset, 'rak', 'rak', 'Rak')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['id'])
                ->addColumn($columns['deskripsi'])
                ->addColumn($columns['gambar'])
                ->addColumn($columns['kd'])
                ->addColumn($columns['kg'])
                ->addColumn($columns['pembagi'])
                ->addColumn($columns['qtydos'])
                ->addColumn($columns['hdasar'])
                ->addColumn($columns['stokminimal'])
                ->addColumn($columns['supplier'])
                ->addColumn($columns['minimal'])
                ->addColumn($columns['stok'])
                ->addColumn($columns['rak']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('id')
                ->setOptionsFor('gambar');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new DynamicCombobox('id_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_brg_brginfo_id_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('id', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_brg_brginfo_id_search');
            
            $filterBuilder->addColumn(
                $columns['id'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('deskripsi');
            
            $filterBuilder->addColumn(
                $columns['deskripsi'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('gambar');
            
            $filterBuilder->addColumn(
                $columns['gambar'],
                array(
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('kd_edit');
            $main_editor->SetMaxLength(20);
            
            $filterBuilder->addColumn(
                $columns['kd'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('kg_edit');
            
            $filterBuilder->addColumn(
                $columns['kg'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('pembagi_edit');
            
            $filterBuilder->addColumn(
                $columns['pembagi'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('qtydos_edit');
            
            $filterBuilder->addColumn(
                $columns['qtydos'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('hdasar_edit');
            $main_editor->SetMaxLength(20);
            
            $filterBuilder->addColumn(
                $columns['hdasar'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('stokminimal_edit');
            
            $filterBuilder->addColumn(
                $columns['stokminimal'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('supplier');
            
            $filterBuilder->addColumn(
                $columns['supplier'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('minimal_edit');
            
            $filterBuilder->addColumn(
                $columns['minimal'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('stok_edit');
            
            $filterBuilder->addColumn(
                $columns['stok'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('rak_edit');
            $main_editor->SetMaxLength(20);
            
            $filterBuilder->addColumn(
                $columns['rak'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
        }
    
        protected function AddOperationsColumns(Grid $grid)
        {
            $actions = $grid->getActions();
            $actions->setCaption($this->GetLocalizerCaptions()->GetMessageString('Actions'));
            $actions->setPosition(ActionList::POSITION_LEFT);
            
            if ($this->GetSecurityInfo()->HasViewGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('View'), OPERATION_VIEW, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
            
            if ($this->GetSecurityInfo()->HasEditGrant())
            {
                $operation = new AjaxOperation(OPERATION_EDIT,
                    $this->GetLocalizerCaptions()->GetMessageString('Edit'),
                    $this->GetLocalizerCaptions()->GetMessageString('Edit'), $this->dataset,
                    $this->GetGridEditHandler(), $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowEditButtonHandler', $this);
            }
            
            if ($this->GetSecurityInfo()->HasDeleteGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Delete'), OPERATION_DELETE, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowDeleteButtonHandler', $this);
                $operation->SetAdditionalAttribute('data-modal-operation', 'delete');
                $operation->SetAdditionalAttribute('data-delete-handler-name', $this->GetModalGridDeleteHandler());
            }
            
            if ($this->GetSecurityInfo()->HasAddGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Copy'), OPERATION_COPY, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
        }
    
        protected function AddFieldColumns(Grid $grid, $withDetails = true)
        {
            //
            // View column for idgol field
            //
            $column = new NumberViewColumn('id', 'id_idgol', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for deskripsi field
            //
            $column = new TextViewColumn('deskripsi', 'deskripsi', 'Deskripsi', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for gambar field
            //
            $column = new DownloadDataColumn('gambar', 'gambar', 'Gambar', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for kd field
            //
            $column = new TextViewColumn('kd', 'kd', 'Kd', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for kg field
            //
            $column = new NumberViewColumn('kg', 'kg', 'Kg', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for pembagi field
            //
            $column = new NumberViewColumn('pembagi', 'pembagi', 'Pembagi', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for qtydos field
            //
            $column = new NumberViewColumn('qtydos', 'qtydos', 'Qtydos', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for hdasar field
            //
            $column = new TextViewColumn('hdasar', 'hdasar', 'Hdasar', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for stokminimal field
            //
            $column = new NumberViewColumn('stokminimal', 'stokminimal', 'Stokminimal', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for supplier field
            //
            $column = new TextViewColumn('supplier', 'supplier', 'Supplier', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for minimal field
            //
            $column = new NumberViewColumn('minimal', 'minimal', 'Minimal', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for stok field
            //
            $column = new NumberViewColumn('stok', 'stok', 'Stok', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for rak field
            //
            $column = new TextViewColumn('rak', 'rak', 'Rak', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for idgol field
            //
            $column = new NumberViewColumn('id', 'id_idgol', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for deskripsi field
            //
            $column = new TextViewColumn('deskripsi', 'deskripsi', 'Deskripsi', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for gambar field
            //
            $column = new DownloadDataColumn('gambar', 'gambar', 'Gambar', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for kd field
            //
            $column = new TextViewColumn('kd', 'kd', 'Kd', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for kg field
            //
            $column = new NumberViewColumn('kg', 'kg', 'Kg', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for pembagi field
            //
            $column = new NumberViewColumn('pembagi', 'pembagi', 'Pembagi', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for qtydos field
            //
            $column = new NumberViewColumn('qtydos', 'qtydos', 'Qtydos', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for hdasar field
            //
            $column = new TextViewColumn('hdasar', 'hdasar', 'Hdasar', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for stokminimal field
            //
            $column = new NumberViewColumn('stokminimal', 'stokminimal', 'Stokminimal', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for supplier field
            //
            $column = new TextViewColumn('supplier', 'supplier', 'Supplier', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for minimal field
            //
            $column = new NumberViewColumn('minimal', 'minimal', 'Minimal', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for stok field
            //
            $column = new NumberViewColumn('stok', 'stok', 'Stok', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for rak field
            //
            $column = new TextViewColumn('rak', 'rak', 'Rak', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for id field
            //
            $editor = new DynamicCombobox('id_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('idgol', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id', 'id', 'id_idgol', 'edit_brg_brginfo_id_search', $editor, $this->dataset, $lookupDataset, 'id', 'idgol', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for deskripsi field
            //
            $editor = new TextAreaEdit('deskripsi_edit', 50, 8);
            $editColumn = new CustomEditColumn('Deskripsi', 'deskripsi', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for gambar field
            //
            $editor = new ImageUploader('gambar_edit');
            $editor->SetShowImage(false);
            $editColumn = new FileUploadingColumn('Gambar', 'gambar', $editor, $this->dataset, false, false, 'brg_brginfo_gambar_handler_edit');
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for kd field
            //
            $editor = new TextEdit('kd_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Kd', 'kd', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for kg field
            //
            $editor = new TextEdit('kg_edit');
            $editColumn = new CustomEditColumn('Kg', 'kg', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for pembagi field
            //
            $editor = new TextEdit('pembagi_edit');
            $editColumn = new CustomEditColumn('Pembagi', 'pembagi', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for qtydos field
            //
            $editor = new TextEdit('qtydos_edit');
            $editColumn = new CustomEditColumn('Qtydos', 'qtydos', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for hdasar field
            //
            $editor = new TextEdit('hdasar_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Hdasar', 'hdasar', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for stokminimal field
            //
            $editor = new TextEdit('stokminimal_edit');
            $editColumn = new CustomEditColumn('Stokminimal', 'stokminimal', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for supplier field
            //
            $editor = new TextAreaEdit('supplier_edit', 50, 8);
            $editColumn = new CustomEditColumn('Supplier', 'supplier', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for minimal field
            //
            $editor = new TextEdit('minimal_edit');
            $editColumn = new CustomEditColumn('Minimal', 'minimal', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for stok field
            //
            $editor = new TextEdit('stok_edit');
            $editColumn = new CustomEditColumn('Stok', 'stok', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for rak field
            //
            $editor = new TextEdit('rak_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Rak', 'rak', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for deskripsi field
            //
            $editor = new TextAreaEdit('deskripsi_edit', 50, 8);
            $editColumn = new CustomEditColumn('Deskripsi', 'deskripsi', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for gambar field
            //
            $editor = new ImageUploader('gambar_edit');
            $editor->SetShowImage(false);
            $editColumn = new FileUploadingColumn('Gambar', 'gambar', $editor, $this->dataset, false, false, 'brg_brginfo_gambar_handler_multi_edit');
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for kd field
            //
            $editor = new TextEdit('kd_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Kd', 'kd', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for kg field
            //
            $editor = new TextEdit('kg_edit');
            $editColumn = new CustomEditColumn('Kg', 'kg', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for pembagi field
            //
            $editor = new TextEdit('pembagi_edit');
            $editColumn = new CustomEditColumn('Pembagi', 'pembagi', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for qtydos field
            //
            $editor = new TextEdit('qtydos_edit');
            $editColumn = new CustomEditColumn('Qtydos', 'qtydos', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for hdasar field
            //
            $editor = new TextEdit('hdasar_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Hdasar', 'hdasar', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for stokminimal field
            //
            $editor = new TextEdit('stokminimal_edit');
            $editColumn = new CustomEditColumn('Stokminimal', 'stokminimal', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for supplier field
            //
            $editor = new TextAreaEdit('supplier_edit', 50, 8);
            $editColumn = new CustomEditColumn('Supplier', 'supplier', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for minimal field
            //
            $editor = new TextEdit('minimal_edit');
            $editColumn = new CustomEditColumn('Minimal', 'minimal', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for stok field
            //
            $editor = new TextEdit('stok_edit');
            $editColumn = new CustomEditColumn('Stok', 'stok', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for rak field
            //
            $editor = new TextEdit('rak_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Rak', 'rak', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for id field
            //
            $editor = new DynamicCombobox('id_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('idgol', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id', 'id', 'id_idgol', 'insert_brg_brginfo_id_search', $editor, $this->dataset, $lookupDataset, 'id', 'idgol', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for deskripsi field
            //
            $editor = new TextAreaEdit('deskripsi_edit', 50, 8);
            $editColumn = new CustomEditColumn('Deskripsi', 'deskripsi', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for gambar field
            //
            $editor = new ImageUploader('gambar_edit');
            $editor->SetShowImage(false);
            $editColumn = new FileUploadingColumn('Gambar', 'gambar', $editor, $this->dataset, false, false, 'brg_brginfo_gambar_handler_insert');
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for kd field
            //
            $editor = new TextEdit('kd_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Kd', 'kd', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for kg field
            //
            $editor = new TextEdit('kg_edit');
            $editColumn = new CustomEditColumn('Kg', 'kg', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for pembagi field
            //
            $editor = new TextEdit('pembagi_edit');
            $editColumn = new CustomEditColumn('Pembagi', 'pembagi', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for qtydos field
            //
            $editor = new TextEdit('qtydos_edit');
            $editColumn = new CustomEditColumn('Qtydos', 'qtydos', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for hdasar field
            //
            $editor = new TextEdit('hdasar_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Hdasar', 'hdasar', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for stokminimal field
            //
            $editor = new TextEdit('stokminimal_edit');
            $editColumn = new CustomEditColumn('Stokminimal', 'stokminimal', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for supplier field
            //
            $editor = new TextAreaEdit('supplier_edit', 50, 8);
            $editColumn = new CustomEditColumn('Supplier', 'supplier', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for minimal field
            //
            $editor = new TextEdit('minimal_edit');
            $editColumn = new CustomEditColumn('Minimal', 'minimal', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for stok field
            //
            $editor = new TextEdit('stok_edit');
            $editColumn = new CustomEditColumn('Stok', 'stok', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for rak field
            //
            $editor = new TextEdit('rak_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Rak', 'rak', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            $grid->SetShowAddButton(true && $this->GetSecurityInfo()->HasAddGrant());
        }
    
        private function AddMultiUploadColumn(Grid $grid)
        {
    
        }
    
        protected function AddPrintColumns(Grid $grid)
        {
            //
            // View column for idgol field
            //
            $column = new NumberViewColumn('id', 'id_idgol', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for deskripsi field
            //
            $column = new TextViewColumn('deskripsi', 'deskripsi', 'Deskripsi', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for gambar field
            //
            $column = new DownloadDataColumn('gambar', 'gambar', 'Gambar', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for kd field
            //
            $column = new TextViewColumn('kd', 'kd', 'Kd', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for kg field
            //
            $column = new NumberViewColumn('kg', 'kg', 'Kg', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddPrintColumn($column);
            
            //
            // View column for pembagi field
            //
            $column = new NumberViewColumn('pembagi', 'pembagi', 'Pembagi', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddPrintColumn($column);
            
            //
            // View column for qtydos field
            //
            $column = new NumberViewColumn('qtydos', 'qtydos', 'Qtydos', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddPrintColumn($column);
            
            //
            // View column for hdasar field
            //
            $column = new TextViewColumn('hdasar', 'hdasar', 'Hdasar', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for stokminimal field
            //
            $column = new NumberViewColumn('stokminimal', 'stokminimal', 'Stokminimal', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for supplier field
            //
            $column = new TextViewColumn('supplier', 'supplier', 'Supplier', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for minimal field
            //
            $column = new NumberViewColumn('minimal', 'minimal', 'Minimal', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddPrintColumn($column);
            
            //
            // View column for stok field
            //
            $column = new NumberViewColumn('stok', 'stok', 'Stok', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddPrintColumn($column);
            
            //
            // View column for rak field
            //
            $column = new TextViewColumn('rak', 'rak', 'Rak', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for idgol field
            //
            $column = new NumberViewColumn('id', 'id_idgol', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for deskripsi field
            //
            $column = new TextViewColumn('deskripsi', 'deskripsi', 'Deskripsi', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for gambar field
            //
            $column = new DownloadDataColumn('gambar', 'gambar', 'Gambar', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for kd field
            //
            $column = new TextViewColumn('kd', 'kd', 'Kd', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for kg field
            //
            $column = new NumberViewColumn('kg', 'kg', 'Kg', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddExportColumn($column);
            
            //
            // View column for pembagi field
            //
            $column = new NumberViewColumn('pembagi', 'pembagi', 'Pembagi', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddExportColumn($column);
            
            //
            // View column for qtydos field
            //
            $column = new NumberViewColumn('qtydos', 'qtydos', 'Qtydos', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddExportColumn($column);
            
            //
            // View column for hdasar field
            //
            $column = new TextViewColumn('hdasar', 'hdasar', 'Hdasar', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for stokminimal field
            //
            $column = new NumberViewColumn('stokminimal', 'stokminimal', 'Stokminimal', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for supplier field
            //
            $column = new TextViewColumn('supplier', 'supplier', 'Supplier', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for minimal field
            //
            $column = new NumberViewColumn('minimal', 'minimal', 'Minimal', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddExportColumn($column);
            
            //
            // View column for stok field
            //
            $column = new NumberViewColumn('stok', 'stok', 'Stok', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddExportColumn($column);
            
            //
            // View column for rak field
            //
            $column = new TextViewColumn('rak', 'rak', 'Rak', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for idgol field
            //
            $column = new NumberViewColumn('id', 'id_idgol', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for deskripsi field
            //
            $column = new TextViewColumn('deskripsi', 'deskripsi', 'Deskripsi', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for gambar field
            //
            $column = new DownloadDataColumn('gambar', 'gambar', 'Gambar', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for kd field
            //
            $column = new TextViewColumn('kd', 'kd', 'Kd', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for kg field
            //
            $column = new NumberViewColumn('kg', 'kg', 'Kg', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddCompareColumn($column);
            
            //
            // View column for pembagi field
            //
            $column = new NumberViewColumn('pembagi', 'pembagi', 'Pembagi', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddCompareColumn($column);
            
            //
            // View column for qtydos field
            //
            $column = new NumberViewColumn('qtydos', 'qtydos', 'Qtydos', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddCompareColumn($column);
            
            //
            // View column for hdasar field
            //
            $column = new TextViewColumn('hdasar', 'hdasar', 'Hdasar', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for stokminimal field
            //
            $column = new NumberViewColumn('stokminimal', 'stokminimal', 'Stokminimal', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for supplier field
            //
            $column = new TextViewColumn('supplier', 'supplier', 'Supplier', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for minimal field
            //
            $column = new NumberViewColumn('minimal', 'minimal', 'Minimal', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddCompareColumn($column);
            
            //
            // View column for stok field
            //
            $column = new NumberViewColumn('stok', 'stok', 'Stok', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddCompareColumn($column);
            
            //
            // View column for rak field
            //
            $column = new TextViewColumn('rak', 'rak', 'Rak', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
        }
    
        private function AddCompareHeaderColumns(Grid $grid)
        {
    
        }
    
        public function GetPageDirection()
        {
            return null;
        }
    
        public function isFilterConditionRequired()
        {
            return false;
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetDisplaySetToNullCheckBox(false);
            $column->SetDisplaySetToDefaultCheckBox(false);
    		$column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
        
        public function GetEnableModalGridInsert() { return true; }
        public function GetEnableModalGridEdit() { return true; }
        
        protected function GetEnableModalGridDelete() { return true; }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset);
            if ($this->GetSecurityInfo()->HasDeleteGrant())
               $result->SetAllowDeleteSelected(true);
            else
               $result->SetAllowDeleteSelected(false);   
            
            ApplyCommonPageSettings($this, $result);
            
            $result->SetUseImagesForActions(true);
            $result->SetUseFixedHeader(false);
            $result->SetShowLineNumbers(true);
            $result->SetViewMode(ViewMode::TABLE);
            $result->setEnableRuntimeCustomization(true);
            $result->setAllowCompare(true);
            $this->AddCompareHeaderColumns($result);
            $this->AddCompareColumns($result);
            $result->setMultiEditAllowed($this->GetSecurityInfo()->HasEditGrant() && true);
            $result->setTableBordered(false);
            $result->setTableCondensed(false);
            
            $result->SetHighlightRowAtHover(true);
            $result->SetWidth('');
            $this->AddOperationsColumns($result);
            $this->AddFieldColumns($result);
            $this->AddSingleRecordViewColumns($result);
            $this->AddEditColumns($result);
            $this->AddMultiEditColumns($result);
            $this->AddInsertColumns($result);
            $this->AddPrintColumns($result);
            $this->AddExportColumns($result);
            $this->AddMultiUploadColumn($result);
    
    
            $this->SetShowPageList(true);
            $this->SetShowTopPageNavigator(true);
            $this->SetShowBottomPageNavigator(true);
            $this->setPrintListAvailable(true);
            $this->setPrintListRecordAvailable(false);
            $this->setPrintOneRecordAvailable(true);
            $this->setAllowPrintSelectedRecords(true);
            $this->setExportListAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportSelectedRecordsAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportListRecordAvailable(array());
            $this->setExportOneRecordAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
    
            return $result;
        }
     
        protected function setClientSideEvents(Grid $grid) {
    
        }
    
        protected function doRegisterHandlers() {
            $handler = new DownloadHTTPHandler($this->dataset, 'gambar', 'gambar_handler', '', '', true);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $handler = new DownloadHTTPHandler($this->dataset, 'gambar', 'gambar_handler', '', '', true);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $handler = new DownloadHTTPHandler($this->dataset, 'gambar', 'gambar_handler', '', '', true);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('idgol', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_brg_brginfo_id_search', 'id', 'idgol', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $handler = new ImageHTTPHandler($this->dataset, 'gambar', 'brg_brginfo_gambar_handler_insert', new NullFilter());
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('idgol', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_brg_brginfo_id_search', 'id', 'idgol', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('idgol', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_brg_brginfo_id_search', 'id', 'idgol', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('idgol', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_brg_brginfo_id_search', 'id', 'idgol', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $handler = new DownloadHTTPHandler($this->dataset, 'gambar', 'gambar_handler', '', '', true);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('idgol', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_brg_brginfo_id_search', 'id', 'idgol', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $handler = new ImageHTTPHandler($this->dataset, 'gambar', 'brg_brginfo_gambar_handler_edit', new NullFilter());
            GetApplication()->RegisterHTTPHandler($handler);
            
            $handler = new ImageHTTPHandler($this->dataset, 'gambar', 'brg_brginfo_gambar_handler_multi_edit', new NullFilter());
            GetApplication()->RegisterHTTPHandler($handler);
        }
       
        protected function doCustomRenderColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderPrintColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderExportColumn($exportType, $fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomDrawRow($rowData, &$cellFontColor, &$cellFontSize, &$cellBgColor, &$cellItalicAttr, &$cellBoldAttr)
        {
    
        }
    
        protected function doExtendedCustomDrawRow($rowData, &$rowCellStyles, &$rowStyles, &$rowClasses, &$cellClasses)
        {
    
        }
    
        protected function doCustomRenderTotal($totalValue, $aggregate, $columnName, &$customText, &$handled)
        {
    
        }
    
        protected function doCustomDefaultValues(&$values, &$handled) 
        {
    
        }
    
        protected function doCustomCompareColumn($columnName, $valueA, $valueB, &$result)
        {
    
        }
    
        protected function doBeforeInsertRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doBeforeUpdateRecord($page, $oldRowData, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doBeforeDeleteRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterInsertRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterUpdateRecord($page, $oldRowData, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterDeleteRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doCustomHTMLHeader($page, &$customHtmlHeaderText)
        { 
    
        }
    
        protected function doGetCustomTemplate($type, $part, $mode, &$result, &$params)
        {
    
        }
    
        protected function doGetCustomExportOptions(Page $page, $exportType, $rowData, &$options)
        {
    
        }
    
        protected function doFileUpload($fieldName, $rowData, &$result, &$accept, $originalFileName, $originalFileExtension, $fileSize, $tempFileName)
        {
    
        }
    
        protected function doPrepareChart(Chart $chart)
        {
    
        }
    
        protected function doPrepareColumnFilter(ColumnFilter $columnFilter)
        {
    
        }
    
        protected function doPrepareFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
    
        }
    
        protected function doGetSelectionFilters(FixedKeysArray $columns, &$result)
        {
    
        }
    
        protected function doGetCustomFormLayout($mode, FixedKeysArray $columns, FormLayout $layout)
        {
    
        }
    
        protected function doGetCustomColumnGroup(FixedKeysArray $columns, ViewColumnGroup $columnGroup)
        {
    
        }
    
        protected function doPageLoaded()
        {
    
        }
    
        protected function doCalculateFields($rowData, $fieldName, &$value)
        {
    
        }
    
        protected function doGetCustomRecordPermissions(Page $page, &$usingCondition, $rowData, &$allowEdit, &$allowDelete, &$mergeWithDefault, &$handled)
        {
    
        }
    
        protected function doAddEnvironmentVariables(Page $page, &$variables)
        {
    
        }
    
    }
    
    
    
    
    // OnBeforePageExecute event handler
    
    
    
    class brg_brgsatuanPage extends DetailPage
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Brgsatuan');
            $this->SetMenuLabel('Brgsatuan');
            $this->SetHeader(GetPagesHeader());
            $this->SetFooter(GetPagesFooter());
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brgsatuan`');
            $this->dataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idsatuan', true, true),
                    new IntegerField('isi', true),
                    new IntegerField('beli'),
                    new IntegerField('jual'),
                    new IntegerField('jual1'),
                    new IntegerField('jual2'),
                    new IntegerField('jual3'),
                    new IntegerField('jual4'),
                    new IntegerField('jual5'),
                    new IntegerField('markupbeli'),
                    new IntegerField('markup1'),
                    new IntegerField('markup2'),
                    new IntegerField('markup3'),
                    new IntegerField('markup4'),
                    new IntegerField('markup5'),
                    new IntegerField('poin'),
                    new IntegerField('aktif')
                )
            );
            $this->dataset->AddLookupField('id', 'brg', new IntegerField('id'), new IntegerField('idgol', false, false, false, false, 'id_idgol', 'id_idgol_brg'), 'id_idgol_brg');
            $this->dataset->AddLookupField('idsatuan', 'satuan', new IntegerField('id'), new StringField('satuan', false, false, false, false, 'idsatuan_satuan', 'idsatuan_satuan_satuan'), 'idsatuan_satuan_satuan');
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function CreatePageNavigator()
        {
            $result = new CompositePageNavigator($this);
            
            $partitionNavigator = new PageNavigator('pnav', $this, $this->dataset);
            $partitionNavigator->SetRowsPerPage(20);
            $result->AddPageNavigator($partitionNavigator);
            
            return $result;
        }
    
        protected function CreateRssGenerator()
        {
            return null;
        }
    
        protected function setupCharts()
        {
    
        }
    
        protected function getFiltersColumns()
        {
            return array(
                new FilterColumn($this->dataset, 'id', 'id_idgol', 'Id'),
                new FilterColumn($this->dataset, 'idsatuan', 'idsatuan_satuan', 'Idsatuan'),
                new FilterColumn($this->dataset, 'isi', 'isi', 'Isi'),
                new FilterColumn($this->dataset, 'beli', 'beli', 'Beli'),
                new FilterColumn($this->dataset, 'jual', 'jual', 'Jual'),
                new FilterColumn($this->dataset, 'jual1', 'jual1', 'Jual1'),
                new FilterColumn($this->dataset, 'jual2', 'jual2', 'Jual2'),
                new FilterColumn($this->dataset, 'jual3', 'jual3', 'Jual3'),
                new FilterColumn($this->dataset, 'jual4', 'jual4', 'Jual4'),
                new FilterColumn($this->dataset, 'jual5', 'jual5', 'Jual5'),
                new FilterColumn($this->dataset, 'markupbeli', 'markupbeli', 'Markupbeli'),
                new FilterColumn($this->dataset, 'markup1', 'markup1', 'Markup1'),
                new FilterColumn($this->dataset, 'markup2', 'markup2', 'Markup2'),
                new FilterColumn($this->dataset, 'markup3', 'markup3', 'Markup3'),
                new FilterColumn($this->dataset, 'markup4', 'markup4', 'Markup4'),
                new FilterColumn($this->dataset, 'markup5', 'markup5', 'Markup5'),
                new FilterColumn($this->dataset, 'poin', 'poin', 'Poin'),
                new FilterColumn($this->dataset, 'aktif', 'aktif', 'Aktif')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['id'])
                ->addColumn($columns['idsatuan'])
                ->addColumn($columns['isi'])
                ->addColumn($columns['beli'])
                ->addColumn($columns['jual'])
                ->addColumn($columns['jual1'])
                ->addColumn($columns['jual2'])
                ->addColumn($columns['jual3'])
                ->addColumn($columns['jual4'])
                ->addColumn($columns['jual5'])
                ->addColumn($columns['markupbeli'])
                ->addColumn($columns['markup1'])
                ->addColumn($columns['markup2'])
                ->addColumn($columns['markup3'])
                ->addColumn($columns['markup4'])
                ->addColumn($columns['markup5'])
                ->addColumn($columns['poin'])
                ->addColumn($columns['aktif']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('id')
                ->setOptionsFor('idsatuan');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new DynamicCombobox('id_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_brg_brgsatuan_id_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('id', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_brg_brgsatuan_id_search');
            
            $filterBuilder->addColumn(
                $columns['id'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('idsatuan_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_brg_brgsatuan_idsatuan_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('idsatuan', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_brg_brgsatuan_idsatuan_search');
            
            $text_editor = new TextEdit('idsatuan');
            
            $filterBuilder->addColumn(
                $columns['idsatuan'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('isi_edit');
            
            $filterBuilder->addColumn(
                $columns['isi'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('beli_edit');
            
            $filterBuilder->addColumn(
                $columns['beli'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('jual_edit');
            
            $filterBuilder->addColumn(
                $columns['jual'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('jual1_edit');
            
            $filterBuilder->addColumn(
                $columns['jual1'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('jual2_edit');
            
            $filterBuilder->addColumn(
                $columns['jual2'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('jual3_edit');
            
            $filterBuilder->addColumn(
                $columns['jual3'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('jual4_edit');
            
            $filterBuilder->addColumn(
                $columns['jual4'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('jual5_edit');
            
            $filterBuilder->addColumn(
                $columns['jual5'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('markupbeli_edit');
            
            $filterBuilder->addColumn(
                $columns['markupbeli'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('markup1_edit');
            
            $filterBuilder->addColumn(
                $columns['markup1'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('markup2_edit');
            
            $filterBuilder->addColumn(
                $columns['markup2'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('markup3_edit');
            
            $filterBuilder->addColumn(
                $columns['markup3'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('markup4_edit');
            
            $filterBuilder->addColumn(
                $columns['markup4'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('markup5_edit');
            
            $filterBuilder->addColumn(
                $columns['markup5'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('poin_edit');
            
            $filterBuilder->addColumn(
                $columns['poin'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('aktif_edit');
            
            $filterBuilder->addColumn(
                $columns['aktif'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
        }
    
        protected function AddOperationsColumns(Grid $grid)
        {
            $actions = $grid->getActions();
            $actions->setCaption($this->GetLocalizerCaptions()->GetMessageString('Actions'));
            $actions->setPosition(ActionList::POSITION_LEFT);
            
            if ($this->GetSecurityInfo()->HasViewGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('View'), OPERATION_VIEW, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
            
            if ($this->GetSecurityInfo()->HasEditGrant())
            {
                $operation = new AjaxOperation(OPERATION_EDIT,
                    $this->GetLocalizerCaptions()->GetMessageString('Edit'),
                    $this->GetLocalizerCaptions()->GetMessageString('Edit'), $this->dataset,
                    $this->GetGridEditHandler(), $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowEditButtonHandler', $this);
            }
            
            if ($this->GetSecurityInfo()->HasDeleteGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Delete'), OPERATION_DELETE, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowDeleteButtonHandler', $this);
                $operation->SetAdditionalAttribute('data-modal-operation', 'delete');
                $operation->SetAdditionalAttribute('data-delete-handler-name', $this->GetModalGridDeleteHandler());
            }
            
            if ($this->GetSecurityInfo()->HasAddGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Copy'), OPERATION_COPY, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
        }
    
        protected function AddFieldColumns(Grid $grid, $withDetails = true)
        {
            //
            // View column for idgol field
            //
            $column = new NumberViewColumn('id', 'id_idgol', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for satuan field
            //
            $column = new TextViewColumn('idsatuan', 'idsatuan_satuan', 'Idsatuan', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for isi field
            //
            $column = new NumberViewColumn('isi', 'isi', 'Isi', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for beli field
            //
            $column = new NumberViewColumn('beli', 'beli', 'Beli', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for jual field
            //
            $column = new NumberViewColumn('jual', 'jual', 'Jual', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for jual1 field
            //
            $column = new NumberViewColumn('jual1', 'jual1', 'Jual1', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for jual2 field
            //
            $column = new NumberViewColumn('jual2', 'jual2', 'Jual2', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for jual3 field
            //
            $column = new NumberViewColumn('jual3', 'jual3', 'Jual3', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for jual4 field
            //
            $column = new NumberViewColumn('jual4', 'jual4', 'Jual4', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for jual5 field
            //
            $column = new NumberViewColumn('jual5', 'jual5', 'Jual5', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for markupbeli field
            //
            $column = new NumberViewColumn('markupbeli', 'markupbeli', 'Markupbeli', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for markup1 field
            //
            $column = new NumberViewColumn('markup1', 'markup1', 'Markup1', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for markup2 field
            //
            $column = new NumberViewColumn('markup2', 'markup2', 'Markup2', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for markup3 field
            //
            $column = new NumberViewColumn('markup3', 'markup3', 'Markup3', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for markup4 field
            //
            $column = new NumberViewColumn('markup4', 'markup4', 'Markup4', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for markup5 field
            //
            $column = new NumberViewColumn('markup5', 'markup5', 'Markup5', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for poin field
            //
            $column = new NumberViewColumn('poin', 'poin', 'Poin', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for aktif field
            //
            $column = new NumberViewColumn('aktif', 'aktif', 'Aktif', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for idgol field
            //
            $column = new NumberViewColumn('id', 'id_idgol', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for satuan field
            //
            $column = new TextViewColumn('idsatuan', 'idsatuan_satuan', 'Idsatuan', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for isi field
            //
            $column = new NumberViewColumn('isi', 'isi', 'Isi', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for beli field
            //
            $column = new NumberViewColumn('beli', 'beli', 'Beli', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for jual field
            //
            $column = new NumberViewColumn('jual', 'jual', 'Jual', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for jual1 field
            //
            $column = new NumberViewColumn('jual1', 'jual1', 'Jual1', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for jual2 field
            //
            $column = new NumberViewColumn('jual2', 'jual2', 'Jual2', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for jual3 field
            //
            $column = new NumberViewColumn('jual3', 'jual3', 'Jual3', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for jual4 field
            //
            $column = new NumberViewColumn('jual4', 'jual4', 'Jual4', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for jual5 field
            //
            $column = new NumberViewColumn('jual5', 'jual5', 'Jual5', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for markupbeli field
            //
            $column = new NumberViewColumn('markupbeli', 'markupbeli', 'Markupbeli', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for markup1 field
            //
            $column = new NumberViewColumn('markup1', 'markup1', 'Markup1', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for markup2 field
            //
            $column = new NumberViewColumn('markup2', 'markup2', 'Markup2', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for markup3 field
            //
            $column = new NumberViewColumn('markup3', 'markup3', 'Markup3', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for markup4 field
            //
            $column = new NumberViewColumn('markup4', 'markup4', 'Markup4', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for markup5 field
            //
            $column = new NumberViewColumn('markup5', 'markup5', 'Markup5', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for poin field
            //
            $column = new NumberViewColumn('poin', 'poin', 'Poin', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for aktif field
            //
            $column = new NumberViewColumn('aktif', 'aktif', 'Aktif', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for id field
            //
            $editor = new DynamicCombobox('id_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('idgol', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id', 'id', 'id_idgol', 'edit_brg_brgsatuan_id_search', $editor, $this->dataset, $lookupDataset, 'id', 'idgol', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for idsatuan field
            //
            $editor = new DynamicCombobox('idsatuan_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`satuan`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('satuan', true)
                )
            );
            $lookupDataset->setOrderByField('satuan', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Idsatuan', 'idsatuan', 'idsatuan_satuan', 'edit_brg_brgsatuan_idsatuan_search', $editor, $this->dataset, $lookupDataset, 'id', 'satuan', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for isi field
            //
            $editor = new TextEdit('isi_edit');
            $editColumn = new CustomEditColumn('Isi', 'isi', $editor, $this->dataset);
            $editColumn->SetAllowSetToDefault(true);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for beli field
            //
            $editor = new TextEdit('beli_edit');
            $editColumn = new CustomEditColumn('Beli', 'beli', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for jual field
            //
            $editor = new TextEdit('jual_edit');
            $editColumn = new CustomEditColumn('Jual', 'jual', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for jual1 field
            //
            $editor = new TextEdit('jual1_edit');
            $editColumn = new CustomEditColumn('Jual1', 'jual1', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for jual2 field
            //
            $editor = new TextEdit('jual2_edit');
            $editColumn = new CustomEditColumn('Jual2', 'jual2', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for jual3 field
            //
            $editor = new TextEdit('jual3_edit');
            $editColumn = new CustomEditColumn('Jual3', 'jual3', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for jual4 field
            //
            $editor = new TextEdit('jual4_edit');
            $editColumn = new CustomEditColumn('Jual4', 'jual4', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for jual5 field
            //
            $editor = new TextEdit('jual5_edit');
            $editColumn = new CustomEditColumn('Jual5', 'jual5', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for markupbeli field
            //
            $editor = new TextEdit('markupbeli_edit');
            $editColumn = new CustomEditColumn('Markupbeli', 'markupbeli', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for markup1 field
            //
            $editor = new TextEdit('markup1_edit');
            $editColumn = new CustomEditColumn('Markup1', 'markup1', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for markup2 field
            //
            $editor = new TextEdit('markup2_edit');
            $editColumn = new CustomEditColumn('Markup2', 'markup2', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for markup3 field
            //
            $editor = new TextEdit('markup3_edit');
            $editColumn = new CustomEditColumn('Markup3', 'markup3', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for markup4 field
            //
            $editor = new TextEdit('markup4_edit');
            $editColumn = new CustomEditColumn('Markup4', 'markup4', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for markup5 field
            //
            $editor = new TextEdit('markup5_edit');
            $editColumn = new CustomEditColumn('Markup5', 'markup5', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for poin field
            //
            $editor = new TextEdit('poin_edit');
            $editColumn = new CustomEditColumn('Poin', 'poin', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for aktif field
            //
            $editor = new TextEdit('aktif_edit');
            $editColumn = new CustomEditColumn('Aktif', 'aktif', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for isi field
            //
            $editor = new TextEdit('isi_edit');
            $editColumn = new CustomEditColumn('Isi', 'isi', $editor, $this->dataset);
            $editColumn->SetAllowSetToDefault(true);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for beli field
            //
            $editor = new TextEdit('beli_edit');
            $editColumn = new CustomEditColumn('Beli', 'beli', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for jual field
            //
            $editor = new TextEdit('jual_edit');
            $editColumn = new CustomEditColumn('Jual', 'jual', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for jual1 field
            //
            $editor = new TextEdit('jual1_edit');
            $editColumn = new CustomEditColumn('Jual1', 'jual1', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for jual2 field
            //
            $editor = new TextEdit('jual2_edit');
            $editColumn = new CustomEditColumn('Jual2', 'jual2', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for jual3 field
            //
            $editor = new TextEdit('jual3_edit');
            $editColumn = new CustomEditColumn('Jual3', 'jual3', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for jual4 field
            //
            $editor = new TextEdit('jual4_edit');
            $editColumn = new CustomEditColumn('Jual4', 'jual4', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for jual5 field
            //
            $editor = new TextEdit('jual5_edit');
            $editColumn = new CustomEditColumn('Jual5', 'jual5', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for markupbeli field
            //
            $editor = new TextEdit('markupbeli_edit');
            $editColumn = new CustomEditColumn('Markupbeli', 'markupbeli', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for markup1 field
            //
            $editor = new TextEdit('markup1_edit');
            $editColumn = new CustomEditColumn('Markup1', 'markup1', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for markup2 field
            //
            $editor = new TextEdit('markup2_edit');
            $editColumn = new CustomEditColumn('Markup2', 'markup2', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for markup3 field
            //
            $editor = new TextEdit('markup3_edit');
            $editColumn = new CustomEditColumn('Markup3', 'markup3', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for markup4 field
            //
            $editor = new TextEdit('markup4_edit');
            $editColumn = new CustomEditColumn('Markup4', 'markup4', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for markup5 field
            //
            $editor = new TextEdit('markup5_edit');
            $editColumn = new CustomEditColumn('Markup5', 'markup5', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for poin field
            //
            $editor = new TextEdit('poin_edit');
            $editColumn = new CustomEditColumn('Poin', 'poin', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for aktif field
            //
            $editor = new TextEdit('aktif_edit');
            $editColumn = new CustomEditColumn('Aktif', 'aktif', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for id field
            //
            $editor = new DynamicCombobox('id_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('idgol', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id', 'id', 'id_idgol', 'insert_brg_brgsatuan_id_search', $editor, $this->dataset, $lookupDataset, 'id', 'idgol', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for idsatuan field
            //
            $editor = new DynamicCombobox('idsatuan_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`satuan`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('satuan', true)
                )
            );
            $lookupDataset->setOrderByField('satuan', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Idsatuan', 'idsatuan', 'idsatuan_satuan', 'insert_brg_brgsatuan_idsatuan_search', $editor, $this->dataset, $lookupDataset, 'id', 'satuan', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for isi field
            //
            $editor = new TextEdit('isi_edit');
            $editColumn = new CustomEditColumn('Isi', 'isi', $editor, $this->dataset);
            $editColumn->SetAllowSetToDefault(true);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for beli field
            //
            $editor = new TextEdit('beli_edit');
            $editColumn = new CustomEditColumn('Beli', 'beli', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for jual field
            //
            $editor = new TextEdit('jual_edit');
            $editColumn = new CustomEditColumn('Jual', 'jual', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for jual1 field
            //
            $editor = new TextEdit('jual1_edit');
            $editColumn = new CustomEditColumn('Jual1', 'jual1', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for jual2 field
            //
            $editor = new TextEdit('jual2_edit');
            $editColumn = new CustomEditColumn('Jual2', 'jual2', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for jual3 field
            //
            $editor = new TextEdit('jual3_edit');
            $editColumn = new CustomEditColumn('Jual3', 'jual3', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for jual4 field
            //
            $editor = new TextEdit('jual4_edit');
            $editColumn = new CustomEditColumn('Jual4', 'jual4', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for jual5 field
            //
            $editor = new TextEdit('jual5_edit');
            $editColumn = new CustomEditColumn('Jual5', 'jual5', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for markupbeli field
            //
            $editor = new TextEdit('markupbeli_edit');
            $editColumn = new CustomEditColumn('Markupbeli', 'markupbeli', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for markup1 field
            //
            $editor = new TextEdit('markup1_edit');
            $editColumn = new CustomEditColumn('Markup1', 'markup1', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for markup2 field
            //
            $editor = new TextEdit('markup2_edit');
            $editColumn = new CustomEditColumn('Markup2', 'markup2', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for markup3 field
            //
            $editor = new TextEdit('markup3_edit');
            $editColumn = new CustomEditColumn('Markup3', 'markup3', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for markup4 field
            //
            $editor = new TextEdit('markup4_edit');
            $editColumn = new CustomEditColumn('Markup4', 'markup4', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for markup5 field
            //
            $editor = new TextEdit('markup5_edit');
            $editColumn = new CustomEditColumn('Markup5', 'markup5', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for poin field
            //
            $editor = new TextEdit('poin_edit');
            $editColumn = new CustomEditColumn('Poin', 'poin', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for aktif field
            //
            $editor = new TextEdit('aktif_edit');
            $editColumn = new CustomEditColumn('Aktif', 'aktif', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            $grid->SetShowAddButton(true && $this->GetSecurityInfo()->HasAddGrant());
        }
    
        private function AddMultiUploadColumn(Grid $grid)
        {
    
        }
    
        protected function AddPrintColumns(Grid $grid)
        {
            //
            // View column for idgol field
            //
            $column = new NumberViewColumn('id', 'id_idgol', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for satuan field
            //
            $column = new TextViewColumn('idsatuan', 'idsatuan_satuan', 'Idsatuan', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for isi field
            //
            $column = new NumberViewColumn('isi', 'isi', 'Isi', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddPrintColumn($column);
            
            //
            // View column for beli field
            //
            $column = new NumberViewColumn('beli', 'beli', 'Beli', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddPrintColumn($column);
            
            //
            // View column for jual field
            //
            $column = new NumberViewColumn('jual', 'jual', 'Jual', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddPrintColumn($column);
            
            //
            // View column for jual1 field
            //
            $column = new NumberViewColumn('jual1', 'jual1', 'Jual1', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddPrintColumn($column);
            
            //
            // View column for jual2 field
            //
            $column = new NumberViewColumn('jual2', 'jual2', 'Jual2', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddPrintColumn($column);
            
            //
            // View column for jual3 field
            //
            $column = new NumberViewColumn('jual3', 'jual3', 'Jual3', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddPrintColumn($column);
            
            //
            // View column for jual4 field
            //
            $column = new NumberViewColumn('jual4', 'jual4', 'Jual4', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddPrintColumn($column);
            
            //
            // View column for jual5 field
            //
            $column = new NumberViewColumn('jual5', 'jual5', 'Jual5', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddPrintColumn($column);
            
            //
            // View column for markupbeli field
            //
            $column = new NumberViewColumn('markupbeli', 'markupbeli', 'Markupbeli', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddPrintColumn($column);
            
            //
            // View column for markup1 field
            //
            $column = new NumberViewColumn('markup1', 'markup1', 'Markup1', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddPrintColumn($column);
            
            //
            // View column for markup2 field
            //
            $column = new NumberViewColumn('markup2', 'markup2', 'Markup2', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddPrintColumn($column);
            
            //
            // View column for markup3 field
            //
            $column = new NumberViewColumn('markup3', 'markup3', 'Markup3', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddPrintColumn($column);
            
            //
            // View column for markup4 field
            //
            $column = new NumberViewColumn('markup4', 'markup4', 'Markup4', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddPrintColumn($column);
            
            //
            // View column for markup5 field
            //
            $column = new NumberViewColumn('markup5', 'markup5', 'Markup5', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddPrintColumn($column);
            
            //
            // View column for poin field
            //
            $column = new NumberViewColumn('poin', 'poin', 'Poin', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddPrintColumn($column);
            
            //
            // View column for aktif field
            //
            $column = new NumberViewColumn('aktif', 'aktif', 'Aktif', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for idgol field
            //
            $column = new NumberViewColumn('id', 'id_idgol', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for satuan field
            //
            $column = new TextViewColumn('idsatuan', 'idsatuan_satuan', 'Idsatuan', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for isi field
            //
            $column = new NumberViewColumn('isi', 'isi', 'Isi', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddExportColumn($column);
            
            //
            // View column for beli field
            //
            $column = new NumberViewColumn('beli', 'beli', 'Beli', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddExportColumn($column);
            
            //
            // View column for jual field
            //
            $column = new NumberViewColumn('jual', 'jual', 'Jual', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddExportColumn($column);
            
            //
            // View column for jual1 field
            //
            $column = new NumberViewColumn('jual1', 'jual1', 'Jual1', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddExportColumn($column);
            
            //
            // View column for jual2 field
            //
            $column = new NumberViewColumn('jual2', 'jual2', 'Jual2', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddExportColumn($column);
            
            //
            // View column for jual3 field
            //
            $column = new NumberViewColumn('jual3', 'jual3', 'Jual3', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddExportColumn($column);
            
            //
            // View column for jual4 field
            //
            $column = new NumberViewColumn('jual4', 'jual4', 'Jual4', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddExportColumn($column);
            
            //
            // View column for jual5 field
            //
            $column = new NumberViewColumn('jual5', 'jual5', 'Jual5', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddExportColumn($column);
            
            //
            // View column for markupbeli field
            //
            $column = new NumberViewColumn('markupbeli', 'markupbeli', 'Markupbeli', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddExportColumn($column);
            
            //
            // View column for markup1 field
            //
            $column = new NumberViewColumn('markup1', 'markup1', 'Markup1', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddExportColumn($column);
            
            //
            // View column for markup2 field
            //
            $column = new NumberViewColumn('markup2', 'markup2', 'Markup2', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddExportColumn($column);
            
            //
            // View column for markup3 field
            //
            $column = new NumberViewColumn('markup3', 'markup3', 'Markup3', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddExportColumn($column);
            
            //
            // View column for markup4 field
            //
            $column = new NumberViewColumn('markup4', 'markup4', 'Markup4', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddExportColumn($column);
            
            //
            // View column for markup5 field
            //
            $column = new NumberViewColumn('markup5', 'markup5', 'Markup5', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddExportColumn($column);
            
            //
            // View column for poin field
            //
            $column = new NumberViewColumn('poin', 'poin', 'Poin', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddExportColumn($column);
            
            //
            // View column for aktif field
            //
            $column = new NumberViewColumn('aktif', 'aktif', 'Aktif', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for idgol field
            //
            $column = new NumberViewColumn('id', 'id_idgol', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for satuan field
            //
            $column = new TextViewColumn('idsatuan', 'idsatuan_satuan', 'Idsatuan', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for isi field
            //
            $column = new NumberViewColumn('isi', 'isi', 'Isi', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddCompareColumn($column);
            
            //
            // View column for beli field
            //
            $column = new NumberViewColumn('beli', 'beli', 'Beli', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddCompareColumn($column);
            
            //
            // View column for jual field
            //
            $column = new NumberViewColumn('jual', 'jual', 'Jual', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddCompareColumn($column);
            
            //
            // View column for jual1 field
            //
            $column = new NumberViewColumn('jual1', 'jual1', 'Jual1', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddCompareColumn($column);
            
            //
            // View column for jual2 field
            //
            $column = new NumberViewColumn('jual2', 'jual2', 'Jual2', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddCompareColumn($column);
            
            //
            // View column for jual3 field
            //
            $column = new NumberViewColumn('jual3', 'jual3', 'Jual3', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddCompareColumn($column);
            
            //
            // View column for jual4 field
            //
            $column = new NumberViewColumn('jual4', 'jual4', 'Jual4', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddCompareColumn($column);
            
            //
            // View column for jual5 field
            //
            $column = new NumberViewColumn('jual5', 'jual5', 'Jual5', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddCompareColumn($column);
            
            //
            // View column for markupbeli field
            //
            $column = new NumberViewColumn('markupbeli', 'markupbeli', 'Markupbeli', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddCompareColumn($column);
            
            //
            // View column for markup1 field
            //
            $column = new NumberViewColumn('markup1', 'markup1', 'Markup1', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddCompareColumn($column);
            
            //
            // View column for markup2 field
            //
            $column = new NumberViewColumn('markup2', 'markup2', 'Markup2', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddCompareColumn($column);
            
            //
            // View column for markup3 field
            //
            $column = new NumberViewColumn('markup3', 'markup3', 'Markup3', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddCompareColumn($column);
            
            //
            // View column for markup4 field
            //
            $column = new NumberViewColumn('markup4', 'markup4', 'Markup4', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddCompareColumn($column);
            
            //
            // View column for markup5 field
            //
            $column = new NumberViewColumn('markup5', 'markup5', 'Markup5', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddCompareColumn($column);
            
            //
            // View column for poin field
            //
            $column = new NumberViewColumn('poin', 'poin', 'Poin', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddCompareColumn($column);
            
            //
            // View column for aktif field
            //
            $column = new NumberViewColumn('aktif', 'aktif', 'Aktif', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
        }
    
        private function AddCompareHeaderColumns(Grid $grid)
        {
    
        }
    
        public function GetPageDirection()
        {
            return null;
        }
    
        public function isFilterConditionRequired()
        {
            return false;
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetDisplaySetToNullCheckBox(false);
            $column->SetDisplaySetToDefaultCheckBox(false);
    		$column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
        
        public function GetEnableModalGridInsert() { return true; }
        public function GetEnableModalGridEdit() { return true; }
        
        protected function GetEnableModalGridDelete() { return true; }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset);
            if ($this->GetSecurityInfo()->HasDeleteGrant())
               $result->SetAllowDeleteSelected(true);
            else
               $result->SetAllowDeleteSelected(false);   
            
            ApplyCommonPageSettings($this, $result);
            
            $result->SetUseImagesForActions(true);
            $result->SetUseFixedHeader(false);
            $result->SetShowLineNumbers(true);
            $result->SetViewMode(ViewMode::TABLE);
            $result->setEnableRuntimeCustomization(true);
            $result->setAllowCompare(true);
            $this->AddCompareHeaderColumns($result);
            $this->AddCompareColumns($result);
            $result->setMultiEditAllowed($this->GetSecurityInfo()->HasEditGrant() && true);
            $result->setTableBordered(false);
            $result->setTableCondensed(false);
            
            $result->SetHighlightRowAtHover(true);
            $result->SetWidth('');
            $this->AddOperationsColumns($result);
            $this->AddFieldColumns($result);
            $this->AddSingleRecordViewColumns($result);
            $this->AddEditColumns($result);
            $this->AddMultiEditColumns($result);
            $this->AddInsertColumns($result);
            $this->AddPrintColumns($result);
            $this->AddExportColumns($result);
            $this->AddMultiUploadColumn($result);
    
    
            $this->SetShowPageList(true);
            $this->SetShowTopPageNavigator(true);
            $this->SetShowBottomPageNavigator(true);
            $this->setPrintListAvailable(true);
            $this->setPrintListRecordAvailable(false);
            $this->setPrintOneRecordAvailable(true);
            $this->setAllowPrintSelectedRecords(true);
            $this->setExportListAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportSelectedRecordsAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportListRecordAvailable(array());
            $this->setExportOneRecordAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
    
            return $result;
        }
     
        protected function setClientSideEvents(Grid $grid) {
    
        }
    
        protected function doRegisterHandlers() {
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('idgol', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_brg_brgsatuan_id_search', 'id', 'idgol', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`satuan`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('satuan', true)
                )
            );
            $lookupDataset->setOrderByField('satuan', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_brg_brgsatuan_idsatuan_search', 'id', 'satuan', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('idgol', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_brg_brgsatuan_id_search', 'id', 'idgol', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`satuan`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('satuan', true)
                )
            );
            $lookupDataset->setOrderByField('satuan', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_brg_brgsatuan_idsatuan_search', 'id', 'satuan', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('idgol', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_brg_brgsatuan_id_search', 'id', 'idgol', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`satuan`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('satuan', true)
                )
            );
            $lookupDataset->setOrderByField('satuan', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_brg_brgsatuan_idsatuan_search', 'id', 'satuan', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
        }
       
        protected function doCustomRenderColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderPrintColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderExportColumn($exportType, $fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomDrawRow($rowData, &$cellFontColor, &$cellFontSize, &$cellBgColor, &$cellItalicAttr, &$cellBoldAttr)
        {
    
        }
    
        protected function doExtendedCustomDrawRow($rowData, &$rowCellStyles, &$rowStyles, &$rowClasses, &$cellClasses)
        {
    
        }
    
        protected function doCustomRenderTotal($totalValue, $aggregate, $columnName, &$customText, &$handled)
        {
    
        }
    
        protected function doCustomDefaultValues(&$values, &$handled) 
        {
    
        }
    
        protected function doCustomCompareColumn($columnName, $valueA, $valueB, &$result)
        {
    
        }
    
        protected function doBeforeInsertRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doBeforeUpdateRecord($page, $oldRowData, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doBeforeDeleteRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterInsertRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterUpdateRecord($page, $oldRowData, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterDeleteRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doCustomHTMLHeader($page, &$customHtmlHeaderText)
        { 
    
        }
    
        protected function doGetCustomTemplate($type, $part, $mode, &$result, &$params)
        {
    
        }
    
        protected function doGetCustomExportOptions(Page $page, $exportType, $rowData, &$options)
        {
    
        }
    
        protected function doFileUpload($fieldName, $rowData, &$result, &$accept, $originalFileName, $originalFileExtension, $fileSize, $tempFileName)
        {
    
        }
    
        protected function doPrepareChart(Chart $chart)
        {
    
        }
    
        protected function doPrepareColumnFilter(ColumnFilter $columnFilter)
        {
    
        }
    
        protected function doPrepareFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
    
        }
    
        protected function doGetSelectionFilters(FixedKeysArray $columns, &$result)
        {
    
        }
    
        protected function doGetCustomFormLayout($mode, FixedKeysArray $columns, FormLayout $layout)
        {
    
        }
    
        protected function doGetCustomColumnGroup(FixedKeysArray $columns, ViewColumnGroup $columnGroup)
        {
    
        }
    
        protected function doPageLoaded()
        {
    
        }
    
        protected function doCalculateFields($rowData, $fieldName, &$value)
        {
    
        }
    
        protected function doGetCustomRecordPermissions(Page $page, &$usingCondition, $rowData, &$allowEdit, &$allowDelete, &$mergeWithDefault, &$handled)
        {
    
        }
    
        protected function doAddEnvironmentVariables(Page $page, &$variables)
        {
    
        }
    
    }
    
    
    
    
    // OnBeforePageExecute event handler
    
    
    
    class brg_fifoPage extends DetailPage
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Fifo');
            $this->SetMenuLabel('Fifo');
            $this->SetHeader(GetPagesHeader());
            $this->SetFooter(GetPagesFooter());
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`fifo`');
            $this->dataset->addFields(
                array(
                    new StringField('idmasuk', true, true),
                    new IntegerField('idtrans'),
                    new IntegerField('idbarang'),
                    new IntegerField('masuk'),
                    new IntegerField('keluar'),
                    new IntegerField('sisa'),
                    new IntegerField('harga'),
                    new IntegerField('cek')
                )
            );
            $this->dataset->AddLookupField('idmasuk', 'trd', new StringField('id'), new StringField('notrans', false, false, false, false, 'idmasuk_notrans', 'idmasuk_notrans_trd'), 'idmasuk_notrans_trd');
            $this->dataset->AddLookupField('idbarang', 'brg', new IntegerField('id'), new IntegerField('idgol', false, false, false, false, 'idbarang_idgol', 'idbarang_idgol_brg'), 'idbarang_idgol_brg');
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function CreatePageNavigator()
        {
            $result = new CompositePageNavigator($this);
            
            $partitionNavigator = new PageNavigator('pnav', $this, $this->dataset);
            $partitionNavigator->SetRowsPerPage(20);
            $result->AddPageNavigator($partitionNavigator);
            
            return $result;
        }
    
        protected function CreateRssGenerator()
        {
            return null;
        }
    
        protected function setupCharts()
        {
    
        }
    
        protected function getFiltersColumns()
        {
            return array(
                new FilterColumn($this->dataset, 'idmasuk', 'idmasuk_notrans', 'Idmasuk'),
                new FilterColumn($this->dataset, 'idtrans', 'idtrans', 'Idtrans'),
                new FilterColumn($this->dataset, 'idbarang', 'idbarang_idgol', 'Idbarang'),
                new FilterColumn($this->dataset, 'masuk', 'masuk', 'Masuk'),
                new FilterColumn($this->dataset, 'keluar', 'keluar', 'Keluar'),
                new FilterColumn($this->dataset, 'sisa', 'sisa', 'Sisa'),
                new FilterColumn($this->dataset, 'harga', 'harga', 'Harga'),
                new FilterColumn($this->dataset, 'cek', 'cek', 'Cek')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['idmasuk'])
                ->addColumn($columns['idtrans'])
                ->addColumn($columns['idbarang'])
                ->addColumn($columns['masuk'])
                ->addColumn($columns['keluar'])
                ->addColumn($columns['sisa'])
                ->addColumn($columns['harga'])
                ->addColumn($columns['cek']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('idmasuk')
                ->setOptionsFor('idbarang');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new DynamicCombobox('idmasuk_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_brg_fifo_idmasuk_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('idmasuk', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_brg_fifo_idmasuk_search');
            
            $text_editor = new TextEdit('idmasuk');
            
            $filterBuilder->addColumn(
                $columns['idmasuk'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('idtrans_edit');
            
            $filterBuilder->addColumn(
                $columns['idtrans'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('idbarang_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_brg_fifo_idbarang_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('idbarang', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_brg_fifo_idbarang_search');
            
            $filterBuilder->addColumn(
                $columns['idbarang'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('masuk_edit');
            
            $filterBuilder->addColumn(
                $columns['masuk'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('keluar_edit');
            
            $filterBuilder->addColumn(
                $columns['keluar'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('sisa_edit');
            
            $filterBuilder->addColumn(
                $columns['sisa'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('harga_edit');
            
            $filterBuilder->addColumn(
                $columns['harga'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('cek_edit');
            
            $filterBuilder->addColumn(
                $columns['cek'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
        }
    
        protected function AddOperationsColumns(Grid $grid)
        {
            $actions = $grid->getActions();
            $actions->setCaption($this->GetLocalizerCaptions()->GetMessageString('Actions'));
            $actions->setPosition(ActionList::POSITION_LEFT);
            
            if ($this->GetSecurityInfo()->HasViewGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('View'), OPERATION_VIEW, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
            
            if ($this->GetSecurityInfo()->HasEditGrant())
            {
                $operation = new AjaxOperation(OPERATION_EDIT,
                    $this->GetLocalizerCaptions()->GetMessageString('Edit'),
                    $this->GetLocalizerCaptions()->GetMessageString('Edit'), $this->dataset,
                    $this->GetGridEditHandler(), $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowEditButtonHandler', $this);
            }
            
            if ($this->GetSecurityInfo()->HasDeleteGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Delete'), OPERATION_DELETE, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowDeleteButtonHandler', $this);
                $operation->SetAdditionalAttribute('data-modal-operation', 'delete');
                $operation->SetAdditionalAttribute('data-delete-handler-name', $this->GetModalGridDeleteHandler());
            }
            
            if ($this->GetSecurityInfo()->HasAddGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Copy'), OPERATION_COPY, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
        }
    
        protected function AddFieldColumns(Grid $grid, $withDetails = true)
        {
            //
            // View column for notrans field
            //
            $column = new TextViewColumn('idmasuk', 'idmasuk_notrans', 'Idmasuk', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for idtrans field
            //
            $column = new NumberViewColumn('idtrans', 'idtrans', 'Idtrans', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for idgol field
            //
            $column = new NumberViewColumn('idbarang', 'idbarang_idgol', 'Idbarang', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for masuk field
            //
            $column = new NumberViewColumn('masuk', 'masuk', 'Masuk', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for keluar field
            //
            $column = new NumberViewColumn('keluar', 'keluar', 'Keluar', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for sisa field
            //
            $column = new NumberViewColumn('sisa', 'sisa', 'Sisa', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for harga field
            //
            $column = new NumberViewColumn('harga', 'harga', 'Harga', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for cek field
            //
            $column = new NumberViewColumn('cek', 'cek', 'Cek', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for notrans field
            //
            $column = new TextViewColumn('idmasuk', 'idmasuk_notrans', 'Idmasuk', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for idtrans field
            //
            $column = new NumberViewColumn('idtrans', 'idtrans', 'Idtrans', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for idgol field
            //
            $column = new NumberViewColumn('idbarang', 'idbarang_idgol', 'Idbarang', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for masuk field
            //
            $column = new NumberViewColumn('masuk', 'masuk', 'Masuk', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for keluar field
            //
            $column = new NumberViewColumn('keluar', 'keluar', 'Keluar', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for sisa field
            //
            $column = new NumberViewColumn('sisa', 'sisa', 'Sisa', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for harga field
            //
            $column = new NumberViewColumn('harga', 'harga', 'Harga', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for cek field
            //
            $column = new NumberViewColumn('cek', 'cek', 'Cek', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for idmasuk field
            //
            $editor = new DynamicCombobox('idmasuk_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`trd`');
            $lookupDataset->addFields(
                array(
                    new StringField('id', true, true),
                    new StringField('notrans', true),
                    new IntegerField('idtrans', true),
                    new IntegerField('idbarang', true),
                    new StringField('tipe'),
                    new StringField('kode', true),
                    new IntegerField('qtynota'),
                    new IntegerField('idsatuan'),
                    new IntegerField('isi'),
                    new IntegerField('harga'),
                    new IntegerField('jumlah'),
                    new IntegerField('diskon'),
                    new StringField('diskon2'),
                    new IntegerField('biaya'),
                    new IntegerField('total'),
                    new StringField('idx')
                )
            );
            $lookupDataset->setOrderByField('notrans', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Idmasuk', 'idmasuk', 'idmasuk_notrans', 'edit_brg_fifo_idmasuk_search', $editor, $this->dataset, $lookupDataset, 'id', 'notrans', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for idtrans field
            //
            $editor = new TextEdit('idtrans_edit');
            $editColumn = new CustomEditColumn('Idtrans', 'idtrans', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for idbarang field
            //
            $editor = new DynamicCombobox('idbarang_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('idgol', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Idbarang', 'idbarang', 'idbarang_idgol', 'edit_brg_fifo_idbarang_search', $editor, $this->dataset, $lookupDataset, 'id', 'idgol', '');
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for masuk field
            //
            $editor = new TextEdit('masuk_edit');
            $editColumn = new CustomEditColumn('Masuk', 'masuk', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for keluar field
            //
            $editor = new TextEdit('keluar_edit');
            $editColumn = new CustomEditColumn('Keluar', 'keluar', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for sisa field
            //
            $editor = new TextEdit('sisa_edit');
            $editColumn = new CustomEditColumn('Sisa', 'sisa', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for harga field
            //
            $editor = new TextEdit('harga_edit');
            $editColumn = new CustomEditColumn('Harga', 'harga', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for cek field
            //
            $editor = new TextEdit('cek_edit');
            $editColumn = new CustomEditColumn('Cek', 'cek', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for idtrans field
            //
            $editor = new TextEdit('idtrans_edit');
            $editColumn = new CustomEditColumn('Idtrans', 'idtrans', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for idbarang field
            //
            $editor = new DynamicCombobox('idbarang_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('idgol', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Idbarang', 'idbarang', 'idbarang_idgol', 'multi_edit_brg_fifo_idbarang_search', $editor, $this->dataset, $lookupDataset, 'id', 'idgol', '');
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for masuk field
            //
            $editor = new TextEdit('masuk_edit');
            $editColumn = new CustomEditColumn('Masuk', 'masuk', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for keluar field
            //
            $editor = new TextEdit('keluar_edit');
            $editColumn = new CustomEditColumn('Keluar', 'keluar', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for sisa field
            //
            $editor = new TextEdit('sisa_edit');
            $editColumn = new CustomEditColumn('Sisa', 'sisa', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for harga field
            //
            $editor = new TextEdit('harga_edit');
            $editColumn = new CustomEditColumn('Harga', 'harga', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for cek field
            //
            $editor = new TextEdit('cek_edit');
            $editColumn = new CustomEditColumn('Cek', 'cek', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for idmasuk field
            //
            $editor = new DynamicCombobox('idmasuk_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`trd`');
            $lookupDataset->addFields(
                array(
                    new StringField('id', true, true),
                    new StringField('notrans', true),
                    new IntegerField('idtrans', true),
                    new IntegerField('idbarang', true),
                    new StringField('tipe'),
                    new StringField('kode', true),
                    new IntegerField('qtynota'),
                    new IntegerField('idsatuan'),
                    new IntegerField('isi'),
                    new IntegerField('harga'),
                    new IntegerField('jumlah'),
                    new IntegerField('diskon'),
                    new StringField('diskon2'),
                    new IntegerField('biaya'),
                    new IntegerField('total'),
                    new StringField('idx')
                )
            );
            $lookupDataset->setOrderByField('notrans', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Idmasuk', 'idmasuk', 'idmasuk_notrans', 'insert_brg_fifo_idmasuk_search', $editor, $this->dataset, $lookupDataset, 'id', 'notrans', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for idtrans field
            //
            $editor = new TextEdit('idtrans_edit');
            $editColumn = new CustomEditColumn('Idtrans', 'idtrans', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for idbarang field
            //
            $editor = new DynamicCombobox('idbarang_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('idgol', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Idbarang', 'idbarang', 'idbarang_idgol', 'insert_brg_fifo_idbarang_search', $editor, $this->dataset, $lookupDataset, 'id', 'idgol', '');
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for masuk field
            //
            $editor = new TextEdit('masuk_edit');
            $editColumn = new CustomEditColumn('Masuk', 'masuk', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for keluar field
            //
            $editor = new TextEdit('keluar_edit');
            $editColumn = new CustomEditColumn('Keluar', 'keluar', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for sisa field
            //
            $editor = new TextEdit('sisa_edit');
            $editColumn = new CustomEditColumn('Sisa', 'sisa', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for harga field
            //
            $editor = new TextEdit('harga_edit');
            $editColumn = new CustomEditColumn('Harga', 'harga', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for cek field
            //
            $editor = new TextEdit('cek_edit');
            $editColumn = new CustomEditColumn('Cek', 'cek', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            $grid->SetShowAddButton(true && $this->GetSecurityInfo()->HasAddGrant());
        }
    
        private function AddMultiUploadColumn(Grid $grid)
        {
    
        }
    
        protected function AddPrintColumns(Grid $grid)
        {
            //
            // View column for notrans field
            //
            $column = new TextViewColumn('idmasuk', 'idmasuk_notrans', 'Idmasuk', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for idtrans field
            //
            $column = new NumberViewColumn('idtrans', 'idtrans', 'Idtrans', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for idgol field
            //
            $column = new NumberViewColumn('idbarang', 'idbarang_idgol', 'Idbarang', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for masuk field
            //
            $column = new NumberViewColumn('masuk', 'masuk', 'Masuk', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddPrintColumn($column);
            
            //
            // View column for keluar field
            //
            $column = new NumberViewColumn('keluar', 'keluar', 'Keluar', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddPrintColumn($column);
            
            //
            // View column for sisa field
            //
            $column = new NumberViewColumn('sisa', 'sisa', 'Sisa', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddPrintColumn($column);
            
            //
            // View column for harga field
            //
            $column = new NumberViewColumn('harga', 'harga', 'Harga', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddPrintColumn($column);
            
            //
            // View column for cek field
            //
            $column = new NumberViewColumn('cek', 'cek', 'Cek', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for notrans field
            //
            $column = new TextViewColumn('idmasuk', 'idmasuk_notrans', 'Idmasuk', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for idtrans field
            //
            $column = new NumberViewColumn('idtrans', 'idtrans', 'Idtrans', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for idgol field
            //
            $column = new NumberViewColumn('idbarang', 'idbarang_idgol', 'Idbarang', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for masuk field
            //
            $column = new NumberViewColumn('masuk', 'masuk', 'Masuk', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddExportColumn($column);
            
            //
            // View column for keluar field
            //
            $column = new NumberViewColumn('keluar', 'keluar', 'Keluar', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddExportColumn($column);
            
            //
            // View column for sisa field
            //
            $column = new NumberViewColumn('sisa', 'sisa', 'Sisa', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddExportColumn($column);
            
            //
            // View column for harga field
            //
            $column = new NumberViewColumn('harga', 'harga', 'Harga', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddExportColumn($column);
            
            //
            // View column for cek field
            //
            $column = new NumberViewColumn('cek', 'cek', 'Cek', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for notrans field
            //
            $column = new TextViewColumn('idmasuk', 'idmasuk_notrans', 'Idmasuk', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for idtrans field
            //
            $column = new NumberViewColumn('idtrans', 'idtrans', 'Idtrans', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for idgol field
            //
            $column = new NumberViewColumn('idbarang', 'idbarang_idgol', 'Idbarang', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for masuk field
            //
            $column = new NumberViewColumn('masuk', 'masuk', 'Masuk', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddCompareColumn($column);
            
            //
            // View column for keluar field
            //
            $column = new NumberViewColumn('keluar', 'keluar', 'Keluar', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddCompareColumn($column);
            
            //
            // View column for sisa field
            //
            $column = new NumberViewColumn('sisa', 'sisa', 'Sisa', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddCompareColumn($column);
            
            //
            // View column for harga field
            //
            $column = new NumberViewColumn('harga', 'harga', 'Harga', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddCompareColumn($column);
            
            //
            // View column for cek field
            //
            $column = new NumberViewColumn('cek', 'cek', 'Cek', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
        }
    
        private function AddCompareHeaderColumns(Grid $grid)
        {
    
        }
    
        public function GetPageDirection()
        {
            return null;
        }
    
        public function isFilterConditionRequired()
        {
            return false;
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetDisplaySetToNullCheckBox(false);
            $column->SetDisplaySetToDefaultCheckBox(false);
    		$column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
        
        public function GetEnableModalGridInsert() { return true; }
        public function GetEnableModalGridEdit() { return true; }
        
        protected function GetEnableModalGridDelete() { return true; }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset);
            if ($this->GetSecurityInfo()->HasDeleteGrant())
               $result->SetAllowDeleteSelected(true);
            else
               $result->SetAllowDeleteSelected(false);   
            
            ApplyCommonPageSettings($this, $result);
            
            $result->SetUseImagesForActions(true);
            $result->SetUseFixedHeader(false);
            $result->SetShowLineNumbers(true);
            $result->SetViewMode(ViewMode::TABLE);
            $result->setEnableRuntimeCustomization(true);
            $result->setAllowCompare(true);
            $this->AddCompareHeaderColumns($result);
            $this->AddCompareColumns($result);
            $result->setMultiEditAllowed($this->GetSecurityInfo()->HasEditGrant() && true);
            $result->setTableBordered(false);
            $result->setTableCondensed(false);
            
            $result->SetHighlightRowAtHover(true);
            $result->SetWidth('');
            $this->AddOperationsColumns($result);
            $this->AddFieldColumns($result);
            $this->AddSingleRecordViewColumns($result);
            $this->AddEditColumns($result);
            $this->AddMultiEditColumns($result);
            $this->AddInsertColumns($result);
            $this->AddPrintColumns($result);
            $this->AddExportColumns($result);
            $this->AddMultiUploadColumn($result);
    
    
            $this->SetShowPageList(true);
            $this->SetShowTopPageNavigator(true);
            $this->SetShowBottomPageNavigator(true);
            $this->setPrintListAvailable(true);
            $this->setPrintListRecordAvailable(false);
            $this->setPrintOneRecordAvailable(true);
            $this->setAllowPrintSelectedRecords(true);
            $this->setExportListAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportSelectedRecordsAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportListRecordAvailable(array());
            $this->setExportOneRecordAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
    
            return $result;
        }
     
        protected function setClientSideEvents(Grid $grid) {
    
        }
    
        protected function doRegisterHandlers() {
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`trd`');
            $lookupDataset->addFields(
                array(
                    new StringField('id', true, true),
                    new StringField('notrans', true),
                    new IntegerField('idtrans', true),
                    new IntegerField('idbarang', true),
                    new StringField('tipe'),
                    new StringField('kode', true),
                    new IntegerField('qtynota'),
                    new IntegerField('idsatuan'),
                    new IntegerField('isi'),
                    new IntegerField('harga'),
                    new IntegerField('jumlah'),
                    new IntegerField('diskon'),
                    new StringField('diskon2'),
                    new IntegerField('biaya'),
                    new IntegerField('total'),
                    new StringField('idx')
                )
            );
            $lookupDataset->setOrderByField('notrans', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_brg_fifo_idmasuk_search', 'id', 'notrans', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('idgol', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_brg_fifo_idbarang_search', 'id', 'idgol', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`trd`');
            $lookupDataset->addFields(
                array(
                    new StringField('id', true, true),
                    new StringField('notrans', true),
                    new IntegerField('idtrans', true),
                    new IntegerField('idbarang', true),
                    new StringField('tipe'),
                    new StringField('kode', true),
                    new IntegerField('qtynota'),
                    new IntegerField('idsatuan'),
                    new IntegerField('isi'),
                    new IntegerField('harga'),
                    new IntegerField('jumlah'),
                    new IntegerField('diskon'),
                    new StringField('diskon2'),
                    new IntegerField('biaya'),
                    new IntegerField('total'),
                    new StringField('idx')
                )
            );
            $lookupDataset->setOrderByField('notrans', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_brg_fifo_idmasuk_search', 'id', 'notrans', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('idgol', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_brg_fifo_idbarang_search', 'id', 'idgol', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`trd`');
            $lookupDataset->addFields(
                array(
                    new StringField('id', true, true),
                    new StringField('notrans', true),
                    new IntegerField('idtrans', true),
                    new IntegerField('idbarang', true),
                    new StringField('tipe'),
                    new StringField('kode', true),
                    new IntegerField('qtynota'),
                    new IntegerField('idsatuan'),
                    new IntegerField('isi'),
                    new IntegerField('harga'),
                    new IntegerField('jumlah'),
                    new IntegerField('diskon'),
                    new StringField('diskon2'),
                    new IntegerField('biaya'),
                    new IntegerField('total'),
                    new StringField('idx')
                )
            );
            $lookupDataset->setOrderByField('notrans', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_brg_fifo_idmasuk_search', 'id', 'notrans', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('idgol', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_brg_fifo_idbarang_search', 'id', 'idgol', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('idgol', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_brg_fifo_idbarang_search', 'id', 'idgol', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
        }
       
        protected function doCustomRenderColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderPrintColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderExportColumn($exportType, $fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomDrawRow($rowData, &$cellFontColor, &$cellFontSize, &$cellBgColor, &$cellItalicAttr, &$cellBoldAttr)
        {
    
        }
    
        protected function doExtendedCustomDrawRow($rowData, &$rowCellStyles, &$rowStyles, &$rowClasses, &$cellClasses)
        {
    
        }
    
        protected function doCustomRenderTotal($totalValue, $aggregate, $columnName, &$customText, &$handled)
        {
    
        }
    
        protected function doCustomDefaultValues(&$values, &$handled) 
        {
    
        }
    
        protected function doCustomCompareColumn($columnName, $valueA, $valueB, &$result)
        {
    
        }
    
        protected function doBeforeInsertRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doBeforeUpdateRecord($page, $oldRowData, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doBeforeDeleteRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterInsertRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterUpdateRecord($page, $oldRowData, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterDeleteRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doCustomHTMLHeader($page, &$customHtmlHeaderText)
        { 
    
        }
    
        protected function doGetCustomTemplate($type, $part, $mode, &$result, &$params)
        {
    
        }
    
        protected function doGetCustomExportOptions(Page $page, $exportType, $rowData, &$options)
        {
    
        }
    
        protected function doFileUpload($fieldName, $rowData, &$result, &$accept, $originalFileName, $originalFileExtension, $fileSize, $tempFileName)
        {
    
        }
    
        protected function doPrepareChart(Chart $chart)
        {
    
        }
    
        protected function doPrepareColumnFilter(ColumnFilter $columnFilter)
        {
    
        }
    
        protected function doPrepareFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
    
        }
    
        protected function doGetSelectionFilters(FixedKeysArray $columns, &$result)
        {
    
        }
    
        protected function doGetCustomFormLayout($mode, FixedKeysArray $columns, FormLayout $layout)
        {
    
        }
    
        protected function doGetCustomColumnGroup(FixedKeysArray $columns, ViewColumnGroup $columnGroup)
        {
    
        }
    
        protected function doPageLoaded()
        {
    
        }
    
        protected function doCalculateFields($rowData, $fieldName, &$value)
        {
    
        }
    
        protected function doGetCustomRecordPermissions(Page $page, &$usingCondition, $rowData, &$allowEdit, &$allowDelete, &$mergeWithDefault, &$handled)
        {
    
        }
    
        protected function doAddEnvironmentVariables(Page $page, &$variables)
        {
    
        }
    
    }
    
    
    
    
    // OnBeforePageExecute event handler
    
    
    
    class brg_stokPage extends DetailPage
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Stok');
            $this->SetMenuLabel('Stok');
            $this->SetHeader(GetPagesHeader());
            $this->SetFooter(GetPagesFooter());
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`stok`');
            $this->dataset->addFields(
                array(
                    new IntegerField('idlokasi', true, true),
                    new IntegerField('idbarang', true, true),
                    new IntegerField('stok')
                )
            );
            $this->dataset->AddLookupField('idlokasi', 'lokasi', new IntegerField('id'), new StringField('kode', false, false, false, false, 'idlokasi_kode', 'idlokasi_kode_lokasi'), 'idlokasi_kode_lokasi');
            $this->dataset->AddLookupField('idbarang', 'brg', new IntegerField('id'), new IntegerField('idgol', false, false, false, false, 'idbarang_idgol', 'idbarang_idgol_brg'), 'idbarang_idgol_brg');
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function CreatePageNavigator()
        {
            $result = new CompositePageNavigator($this);
            
            $partitionNavigator = new PageNavigator('pnav', $this, $this->dataset);
            $partitionNavigator->SetRowsPerPage(20);
            $result->AddPageNavigator($partitionNavigator);
            
            return $result;
        }
    
        protected function CreateRssGenerator()
        {
            return null;
        }
    
        protected function setupCharts()
        {
    
        }
    
        protected function getFiltersColumns()
        {
            return array(
                new FilterColumn($this->dataset, 'idlokasi', 'idlokasi_kode', 'Idlokasi'),
                new FilterColumn($this->dataset, 'idbarang', 'idbarang_idgol', 'Idbarang'),
                new FilterColumn($this->dataset, 'stok', 'stok', 'Stok')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['idlokasi'])
                ->addColumn($columns['idbarang'])
                ->addColumn($columns['stok']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('idlokasi')
                ->setOptionsFor('idbarang');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new DynamicCombobox('idlokasi_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_brg_stok_idlokasi_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('idlokasi', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_brg_stok_idlokasi_search');
            
            $text_editor = new TextEdit('idlokasi');
            
            $filterBuilder->addColumn(
                $columns['idlokasi'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('idbarang_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_brg_stok_idbarang_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('idbarang', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_brg_stok_idbarang_search');
            
            $filterBuilder->addColumn(
                $columns['idbarang'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('stok_edit');
            
            $filterBuilder->addColumn(
                $columns['stok'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
        }
    
        protected function AddOperationsColumns(Grid $grid)
        {
            $actions = $grid->getActions();
            $actions->setCaption($this->GetLocalizerCaptions()->GetMessageString('Actions'));
            $actions->setPosition(ActionList::POSITION_LEFT);
            
            if ($this->GetSecurityInfo()->HasViewGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('View'), OPERATION_VIEW, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
            
            if ($this->GetSecurityInfo()->HasEditGrant())
            {
                $operation = new AjaxOperation(OPERATION_EDIT,
                    $this->GetLocalizerCaptions()->GetMessageString('Edit'),
                    $this->GetLocalizerCaptions()->GetMessageString('Edit'), $this->dataset,
                    $this->GetGridEditHandler(), $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowEditButtonHandler', $this);
            }
            
            if ($this->GetSecurityInfo()->HasDeleteGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Delete'), OPERATION_DELETE, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowDeleteButtonHandler', $this);
                $operation->SetAdditionalAttribute('data-modal-operation', 'delete');
                $operation->SetAdditionalAttribute('data-delete-handler-name', $this->GetModalGridDeleteHandler());
            }
            
            if ($this->GetSecurityInfo()->HasAddGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Copy'), OPERATION_COPY, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
        }
    
        protected function AddFieldColumns(Grid $grid, $withDetails = true)
        {
            //
            // View column for kode field
            //
            $column = new TextViewColumn('idlokasi', 'idlokasi_kode', 'Idlokasi', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for idgol field
            //
            $column = new NumberViewColumn('idbarang', 'idbarang_idgol', 'Idbarang', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for stok field
            //
            $column = new NumberViewColumn('stok', 'stok', 'Stok', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for kode field
            //
            $column = new TextViewColumn('idlokasi', 'idlokasi_kode', 'Idlokasi', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for idgol field
            //
            $column = new NumberViewColumn('idbarang', 'idbarang_idgol', 'Idbarang', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for stok field
            //
            $column = new NumberViewColumn('stok', 'stok', 'Stok', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for idlokasi field
            //
            $editor = new DynamicCombobox('idlokasi_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lokasi`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('alamat'),
                    new StringField('kota'),
                    new StringField('pimpinan'),
                    new StringField('telp'),
                    new StringField('fax'),
                    new IntegerField('aktif')
                )
            );
            $lookupDataset->setOrderByField('kode', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Idlokasi', 'idlokasi', 'idlokasi_kode', 'edit_brg_stok_idlokasi_search', $editor, $this->dataset, $lookupDataset, 'id', 'kode', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for idbarang field
            //
            $editor = new DynamicCombobox('idbarang_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('idgol', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Idbarang', 'idbarang', 'idbarang_idgol', 'edit_brg_stok_idbarang_search', $editor, $this->dataset, $lookupDataset, 'id', 'idgol', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for stok field
            //
            $editor = new TextEdit('stok_edit');
            $editColumn = new CustomEditColumn('Stok', 'stok', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for stok field
            //
            $editor = new TextEdit('stok_edit');
            $editColumn = new CustomEditColumn('Stok', 'stok', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for idlokasi field
            //
            $editor = new DynamicCombobox('idlokasi_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lokasi`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('alamat'),
                    new StringField('kota'),
                    new StringField('pimpinan'),
                    new StringField('telp'),
                    new StringField('fax'),
                    new IntegerField('aktif')
                )
            );
            $lookupDataset->setOrderByField('kode', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Idlokasi', 'idlokasi', 'idlokasi_kode', 'insert_brg_stok_idlokasi_search', $editor, $this->dataset, $lookupDataset, 'id', 'kode', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for idbarang field
            //
            $editor = new DynamicCombobox('idbarang_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('idgol', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Idbarang', 'idbarang', 'idbarang_idgol', 'insert_brg_stok_idbarang_search', $editor, $this->dataset, $lookupDataset, 'id', 'idgol', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for stok field
            //
            $editor = new TextEdit('stok_edit');
            $editColumn = new CustomEditColumn('Stok', 'stok', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            $grid->SetShowAddButton(true && $this->GetSecurityInfo()->HasAddGrant());
        }
    
        private function AddMultiUploadColumn(Grid $grid)
        {
    
        }
    
        protected function AddPrintColumns(Grid $grid)
        {
            //
            // View column for kode field
            //
            $column = new TextViewColumn('idlokasi', 'idlokasi_kode', 'Idlokasi', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for idgol field
            //
            $column = new NumberViewColumn('idbarang', 'idbarang_idgol', 'Idbarang', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for stok field
            //
            $column = new NumberViewColumn('stok', 'stok', 'Stok', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for kode field
            //
            $column = new TextViewColumn('idlokasi', 'idlokasi_kode', 'Idlokasi', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for idgol field
            //
            $column = new NumberViewColumn('idbarang', 'idbarang_idgol', 'Idbarang', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for stok field
            //
            $column = new NumberViewColumn('stok', 'stok', 'Stok', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for kode field
            //
            $column = new TextViewColumn('idlokasi', 'idlokasi_kode', 'Idlokasi', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for idgol field
            //
            $column = new NumberViewColumn('idbarang', 'idbarang_idgol', 'Idbarang', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for stok field
            //
            $column = new NumberViewColumn('stok', 'stok', 'Stok', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddCompareColumn($column);
        }
    
        private function AddCompareHeaderColumns(Grid $grid)
        {
    
        }
    
        public function GetPageDirection()
        {
            return null;
        }
    
        public function isFilterConditionRequired()
        {
            return false;
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetDisplaySetToNullCheckBox(false);
            $column->SetDisplaySetToDefaultCheckBox(false);
    		$column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
        
        public function GetEnableModalGridInsert() { return true; }
        public function GetEnableModalGridEdit() { return true; }
        
        protected function GetEnableModalGridDelete() { return true; }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset);
            if ($this->GetSecurityInfo()->HasDeleteGrant())
               $result->SetAllowDeleteSelected(true);
            else
               $result->SetAllowDeleteSelected(false);   
            
            ApplyCommonPageSettings($this, $result);
            
            $result->SetUseImagesForActions(true);
            $result->SetUseFixedHeader(false);
            $result->SetShowLineNumbers(true);
            $result->SetViewMode(ViewMode::TABLE);
            $result->setEnableRuntimeCustomization(true);
            $result->setAllowCompare(true);
            $this->AddCompareHeaderColumns($result);
            $this->AddCompareColumns($result);
            $result->setMultiEditAllowed($this->GetSecurityInfo()->HasEditGrant() && true);
            $result->setTableBordered(false);
            $result->setTableCondensed(false);
            
            $result->SetHighlightRowAtHover(true);
            $result->SetWidth('');
            $this->AddOperationsColumns($result);
            $this->AddFieldColumns($result);
            $this->AddSingleRecordViewColumns($result);
            $this->AddEditColumns($result);
            $this->AddMultiEditColumns($result);
            $this->AddInsertColumns($result);
            $this->AddPrintColumns($result);
            $this->AddExportColumns($result);
            $this->AddMultiUploadColumn($result);
    
    
            $this->SetShowPageList(true);
            $this->SetShowTopPageNavigator(true);
            $this->SetShowBottomPageNavigator(true);
            $this->setPrintListAvailable(true);
            $this->setPrintListRecordAvailable(false);
            $this->setPrintOneRecordAvailable(true);
            $this->setAllowPrintSelectedRecords(true);
            $this->setExportListAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportSelectedRecordsAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportListRecordAvailable(array());
            $this->setExportOneRecordAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
    
            return $result;
        }
     
        protected function setClientSideEvents(Grid $grid) {
    
        }
    
        protected function doRegisterHandlers() {
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lokasi`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('alamat'),
                    new StringField('kota'),
                    new StringField('pimpinan'),
                    new StringField('telp'),
                    new StringField('fax'),
                    new IntegerField('aktif')
                )
            );
            $lookupDataset->setOrderByField('kode', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_brg_stok_idlokasi_search', 'id', 'kode', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('idgol', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_brg_stok_idbarang_search', 'id', 'idgol', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lokasi`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('alamat'),
                    new StringField('kota'),
                    new StringField('pimpinan'),
                    new StringField('telp'),
                    new StringField('fax'),
                    new IntegerField('aktif')
                )
            );
            $lookupDataset->setOrderByField('kode', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_brg_stok_idlokasi_search', 'id', 'kode', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('idgol', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_brg_stok_idbarang_search', 'id', 'idgol', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lokasi`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('alamat'),
                    new StringField('kota'),
                    new StringField('pimpinan'),
                    new StringField('telp'),
                    new StringField('fax'),
                    new IntegerField('aktif')
                )
            );
            $lookupDataset->setOrderByField('kode', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_brg_stok_idlokasi_search', 'id', 'kode', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('idgol', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_brg_stok_idbarang_search', 'id', 'idgol', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
        }
       
        protected function doCustomRenderColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderPrintColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderExportColumn($exportType, $fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomDrawRow($rowData, &$cellFontColor, &$cellFontSize, &$cellBgColor, &$cellItalicAttr, &$cellBoldAttr)
        {
    
        }
    
        protected function doExtendedCustomDrawRow($rowData, &$rowCellStyles, &$rowStyles, &$rowClasses, &$cellClasses)
        {
    
        }
    
        protected function doCustomRenderTotal($totalValue, $aggregate, $columnName, &$customText, &$handled)
        {
    
        }
    
        protected function doCustomDefaultValues(&$values, &$handled) 
        {
    
        }
    
        protected function doCustomCompareColumn($columnName, $valueA, $valueB, &$result)
        {
    
        }
    
        protected function doBeforeInsertRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doBeforeUpdateRecord($page, $oldRowData, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doBeforeDeleteRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterInsertRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterUpdateRecord($page, $oldRowData, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterDeleteRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doCustomHTMLHeader($page, &$customHtmlHeaderText)
        { 
    
        }
    
        protected function doGetCustomTemplate($type, $part, $mode, &$result, &$params)
        {
    
        }
    
        protected function doGetCustomExportOptions(Page $page, $exportType, $rowData, &$options)
        {
    
        }
    
        protected function doFileUpload($fieldName, $rowData, &$result, &$accept, $originalFileName, $originalFileExtension, $fileSize, $tempFileName)
        {
    
        }
    
        protected function doPrepareChart(Chart $chart)
        {
    
        }
    
        protected function doPrepareColumnFilter(ColumnFilter $columnFilter)
        {
    
        }
    
        protected function doPrepareFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
    
        }
    
        protected function doGetSelectionFilters(FixedKeysArray $columns, &$result)
        {
    
        }
    
        protected function doGetCustomFormLayout($mode, FixedKeysArray $columns, FormLayout $layout)
        {
    
        }
    
        protected function doGetCustomColumnGroup(FixedKeysArray $columns, ViewColumnGroup $columnGroup)
        {
    
        }
    
        protected function doPageLoaded()
        {
    
        }
    
        protected function doCalculateFields($rowData, $fieldName, &$value)
        {
    
        }
    
        protected function doGetCustomRecordPermissions(Page $page, &$usingCondition, $rowData, &$allowEdit, &$allowDelete, &$mergeWithDefault, &$handled)
        {
    
        }
    
        protected function doAddEnvironmentVariables(Page $page, &$variables)
        {
    
        }
    
    }
    
    
    
    
    // OnBeforePageExecute event handler
    
    
    
    class brg_trdPage extends DetailPage
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Trd');
            $this->SetMenuLabel('Trd');
            $this->SetHeader(GetPagesHeader());
            $this->SetFooter(GetPagesFooter());
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`trd`');
            $this->dataset->addFields(
                array(
                    new StringField('id', true, true),
                    new StringField('notrans', true),
                    new IntegerField('idtrans', true),
                    new IntegerField('idbarang', true),
                    new StringField('tipe'),
                    new StringField('kode', true),
                    new IntegerField('qtynota'),
                    new IntegerField('idsatuan'),
                    new IntegerField('isi'),
                    new IntegerField('harga'),
                    new IntegerField('jumlah'),
                    new IntegerField('diskon'),
                    new StringField('diskon2'),
                    new IntegerField('biaya'),
                    new IntegerField('total'),
                    new StringField('idx')
                )
            );
            $this->dataset->AddLookupField('notrans', 'tr', new StringField('notrans'), new IntegerField('id', false, false, false, false, 'notrans_id', 'notrans_id_tr'), 'notrans_id_tr');
            $this->dataset->AddLookupField('idtrans', 'tr', new IntegerField('id'), new StringField('notrans', false, false, false, false, 'idtrans_notrans', 'idtrans_notrans_tr'), 'idtrans_notrans_tr');
            $this->dataset->AddLookupField('idbarang', 'brg', new IntegerField('id'), new IntegerField('idgol', false, false, false, false, 'idbarang_idgol', 'idbarang_idgol_brg'), 'idbarang_idgol_brg');
            $this->dataset->AddLookupField('kode', 'brg', new StringField('kode'), new IntegerField('id', false, false, false, false, 'kode_id', 'kode_id_brg'), 'kode_id_brg');
            $this->dataset->AddLookupField('idsatuan', 'satuan', new IntegerField('id'), new StringField('satuan', false, false, false, false, 'idsatuan_satuan', 'idsatuan_satuan_satuan'), 'idsatuan_satuan_satuan');
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function CreatePageNavigator()
        {
            $result = new CompositePageNavigator($this);
            
            $partitionNavigator = new PageNavigator('pnav', $this, $this->dataset);
            $partitionNavigator->SetRowsPerPage(20);
            $result->AddPageNavigator($partitionNavigator);
            
            return $result;
        }
    
        protected function CreateRssGenerator()
        {
            return null;
        }
    
        protected function setupCharts()
        {
    
        }
    
        protected function getFiltersColumns()
        {
            return array(
                new FilterColumn($this->dataset, 'id', 'id', 'Id'),
                new FilterColumn($this->dataset, 'notrans', 'notrans_id', 'Notrans'),
                new FilterColumn($this->dataset, 'idtrans', 'idtrans_notrans', 'Idtrans'),
                new FilterColumn($this->dataset, 'idbarang', 'idbarang_idgol', 'Idbarang'),
                new FilterColumn($this->dataset, 'tipe', 'tipe', 'Tipe'),
                new FilterColumn($this->dataset, 'kode', 'kode_id', 'Kode'),
                new FilterColumn($this->dataset, 'qtynota', 'qtynota', 'Qtynota'),
                new FilterColumn($this->dataset, 'idsatuan', 'idsatuan_satuan', 'Idsatuan'),
                new FilterColumn($this->dataset, 'isi', 'isi', 'Isi'),
                new FilterColumn($this->dataset, 'harga', 'harga', 'Harga'),
                new FilterColumn($this->dataset, 'jumlah', 'jumlah', 'Jumlah'),
                new FilterColumn($this->dataset, 'diskon', 'diskon', 'Diskon'),
                new FilterColumn($this->dataset, 'diskon2', 'diskon2', 'Diskon2'),
                new FilterColumn($this->dataset, 'biaya', 'biaya', 'Biaya'),
                new FilterColumn($this->dataset, 'total', 'total', 'Total'),
                new FilterColumn($this->dataset, 'idx', 'idx', 'Idx')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['id'])
                ->addColumn($columns['notrans'])
                ->addColumn($columns['idtrans'])
                ->addColumn($columns['idbarang'])
                ->addColumn($columns['tipe'])
                ->addColumn($columns['kode'])
                ->addColumn($columns['qtynota'])
                ->addColumn($columns['idsatuan'])
                ->addColumn($columns['isi'])
                ->addColumn($columns['harga'])
                ->addColumn($columns['jumlah'])
                ->addColumn($columns['diskon'])
                ->addColumn($columns['diskon2'])
                ->addColumn($columns['biaya'])
                ->addColumn($columns['total'])
                ->addColumn($columns['idx']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('notrans')
                ->setOptionsFor('idtrans')
                ->setOptionsFor('idbarang')
                ->setOptionsFor('kode')
                ->setOptionsFor('idsatuan');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new TextEdit('id_edit');
            $main_editor->SetMaxLength(60);
            
            $filterBuilder->addColumn(
                $columns['id'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('notrans_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_brg_trd_notrans_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('notrans', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_brg_trd_notrans_search');
            
            $filterBuilder->addColumn(
                $columns['notrans'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('idtrans_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_brg_trd_idtrans_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('idtrans', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_brg_trd_idtrans_search');
            
            $text_editor = new TextEdit('idtrans');
            
            $filterBuilder->addColumn(
                $columns['idtrans'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('idbarang_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_brg_trd_idbarang_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('idbarang', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_brg_trd_idbarang_search');
            
            $filterBuilder->addColumn(
                $columns['idbarang'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('tipe_edit');
            $main_editor->SetMaxLength(10);
            
            $filterBuilder->addColumn(
                $columns['tipe'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('kode_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_brg_trd_kode_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('kode', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_brg_trd_kode_search');
            
            $filterBuilder->addColumn(
                $columns['kode'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('qtynota_edit');
            
            $filterBuilder->addColumn(
                $columns['qtynota'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('idsatuan_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_brg_trd_idsatuan_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('idsatuan', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_brg_trd_idsatuan_search');
            
            $text_editor = new TextEdit('idsatuan');
            
            $filterBuilder->addColumn(
                $columns['idsatuan'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('isi_edit');
            
            $filterBuilder->addColumn(
                $columns['isi'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('harga_edit');
            
            $filterBuilder->addColumn(
                $columns['harga'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('jumlah_edit');
            
            $filterBuilder->addColumn(
                $columns['jumlah'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('diskon_edit');
            
            $filterBuilder->addColumn(
                $columns['diskon'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('diskon2_edit');
            $main_editor->SetMaxLength(20);
            
            $filterBuilder->addColumn(
                $columns['diskon2'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('biaya_edit');
            
            $filterBuilder->addColumn(
                $columns['biaya'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('total_edit');
            
            $filterBuilder->addColumn(
                $columns['total'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('idx_edit');
            $main_editor->SetMaxLength(60);
            
            $filterBuilder->addColumn(
                $columns['idx'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
        }
    
        protected function AddOperationsColumns(Grid $grid)
        {
            $actions = $grid->getActions();
            $actions->setCaption($this->GetLocalizerCaptions()->GetMessageString('Actions'));
            $actions->setPosition(ActionList::POSITION_LEFT);
            
            if ($this->GetSecurityInfo()->HasViewGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('View'), OPERATION_VIEW, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
            
            if ($this->GetSecurityInfo()->HasEditGrant())
            {
                $operation = new AjaxOperation(OPERATION_EDIT,
                    $this->GetLocalizerCaptions()->GetMessageString('Edit'),
                    $this->GetLocalizerCaptions()->GetMessageString('Edit'), $this->dataset,
                    $this->GetGridEditHandler(), $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowEditButtonHandler', $this);
            }
            
            if ($this->GetSecurityInfo()->HasDeleteGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Delete'), OPERATION_DELETE, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowDeleteButtonHandler', $this);
                $operation->SetAdditionalAttribute('data-modal-operation', 'delete');
                $operation->SetAdditionalAttribute('data-delete-handler-name', $this->GetModalGridDeleteHandler());
            }
            
            if ($this->GetSecurityInfo()->HasAddGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Copy'), OPERATION_COPY, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
        }
    
        protected function AddFieldColumns(Grid $grid, $withDetails = true)
        {
            //
            // View column for id field
            //
            $column = new TextViewColumn('id', 'id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for id field
            //
            $column = new NumberViewColumn('notrans', 'notrans_id', 'Notrans', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for notrans field
            //
            $column = new TextViewColumn('idtrans', 'idtrans_notrans', 'Idtrans', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for idgol field
            //
            $column = new NumberViewColumn('idbarang', 'idbarang_idgol', 'Idbarang', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for tipe field
            //
            $column = new TextViewColumn('tipe', 'tipe', 'Tipe', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for id field
            //
            $column = new NumberViewColumn('kode', 'kode_id', 'Kode', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for qtynota field
            //
            $column = new NumberViewColumn('qtynota', 'qtynota', 'Qtynota', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for satuan field
            //
            $column = new TextViewColumn('idsatuan', 'idsatuan_satuan', 'Idsatuan', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for isi field
            //
            $column = new NumberViewColumn('isi', 'isi', 'Isi', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for harga field
            //
            $column = new NumberViewColumn('harga', 'harga', 'Harga', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for jumlah field
            //
            $column = new NumberViewColumn('jumlah', 'jumlah', 'Jumlah', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for diskon field
            //
            $column = new NumberViewColumn('diskon', 'diskon', 'Diskon', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for diskon2 field
            //
            $column = new TextViewColumn('diskon2', 'diskon2', 'Diskon2', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for biaya field
            //
            $column = new NumberViewColumn('biaya', 'biaya', 'Biaya', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for total field
            //
            $column = new NumberViewColumn('total', 'total', 'Total', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for idx field
            //
            $column = new TextViewColumn('idx', 'idx', 'Idx', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for id field
            //
            $column = new TextViewColumn('id', 'id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for id field
            //
            $column = new NumberViewColumn('notrans', 'notrans_id', 'Notrans', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for notrans field
            //
            $column = new TextViewColumn('idtrans', 'idtrans_notrans', 'Idtrans', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for idgol field
            //
            $column = new NumberViewColumn('idbarang', 'idbarang_idgol', 'Idbarang', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for tipe field
            //
            $column = new TextViewColumn('tipe', 'tipe', 'Tipe', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for id field
            //
            $column = new NumberViewColumn('kode', 'kode_id', 'Kode', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for qtynota field
            //
            $column = new NumberViewColumn('qtynota', 'qtynota', 'Qtynota', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for satuan field
            //
            $column = new TextViewColumn('idsatuan', 'idsatuan_satuan', 'Idsatuan', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for isi field
            //
            $column = new NumberViewColumn('isi', 'isi', 'Isi', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for harga field
            //
            $column = new NumberViewColumn('harga', 'harga', 'Harga', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for jumlah field
            //
            $column = new NumberViewColumn('jumlah', 'jumlah', 'Jumlah', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for diskon field
            //
            $column = new NumberViewColumn('diskon', 'diskon', 'Diskon', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for diskon2 field
            //
            $column = new TextViewColumn('diskon2', 'diskon2', 'Diskon2', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for biaya field
            //
            $column = new NumberViewColumn('biaya', 'biaya', 'Biaya', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for total field
            //
            $column = new NumberViewColumn('total', 'total', 'Total', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for idx field
            //
            $column = new TextViewColumn('idx', 'idx', 'Idx', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for id field
            //
            $editor = new TextEdit('id_edit');
            $editor->SetMaxLength(60);
            $editColumn = new CustomEditColumn('Id', 'id', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for notrans field
            //
            $editor = new DynamicCombobox('notrans_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tr`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('notrans', true),
                    new StringField('kdpc'),
                    new StringField('kdtrans', true),
                    new IntegerField('nobukti'),
                    new DateTimeField('tanggal', true),
                    new IntegerField('idkontak'),
                    new StringField('tipe'),
                    new IntegerField('nilai'),
                    new IntegerField('norek'),
                    new StringField('operator'),
                    new StringField('keterangan'),
                    new IntegerField('idpegawai'),
                    new IntegerField('dihapus')
                )
            );
            $lookupDataset->setOrderByField('id', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Notrans', 'notrans', 'notrans_id', 'edit_brg_trd_notrans_search', $editor, $this->dataset, $lookupDataset, 'notrans', 'id', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for idtrans field
            //
            $editor = new DynamicCombobox('idtrans_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tr`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('notrans', true),
                    new StringField('kdpc'),
                    new StringField('kdtrans', true),
                    new IntegerField('nobukti'),
                    new DateTimeField('tanggal', true),
                    new IntegerField('idkontak'),
                    new StringField('tipe'),
                    new IntegerField('nilai'),
                    new IntegerField('norek'),
                    new StringField('operator'),
                    new StringField('keterangan'),
                    new IntegerField('idpegawai'),
                    new IntegerField('dihapus')
                )
            );
            $lookupDataset->setOrderByField('notrans', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Idtrans', 'idtrans', 'idtrans_notrans', 'edit_brg_trd_idtrans_search', $editor, $this->dataset, $lookupDataset, 'id', 'notrans', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for idbarang field
            //
            $editor = new DynamicCombobox('idbarang_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('idgol', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Idbarang', 'idbarang', 'idbarang_idgol', 'edit_brg_trd_idbarang_search', $editor, $this->dataset, $lookupDataset, 'id', 'idgol', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for tipe field
            //
            $editor = new TextEdit('tipe_edit');
            $editor->SetMaxLength(10);
            $editColumn = new CustomEditColumn('Tipe', 'tipe', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for kode field
            //
            $editor = new DynamicCombobox('kode_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('id', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Kode', 'kode', 'kode_id', 'edit_brg_trd_kode_search', $editor, $this->dataset, $lookupDataset, 'kode', 'id', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for qtynota field
            //
            $editor = new TextEdit('qtynota_edit');
            $editColumn = new CustomEditColumn('Qtynota', 'qtynota', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for idsatuan field
            //
            $editor = new DynamicCombobox('idsatuan_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`satuan`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('satuan', true)
                )
            );
            $lookupDataset->setOrderByField('satuan', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Idsatuan', 'idsatuan', 'idsatuan_satuan', 'edit_brg_trd_idsatuan_search', $editor, $this->dataset, $lookupDataset, 'id', 'satuan', '');
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for isi field
            //
            $editor = new TextEdit('isi_edit');
            $editColumn = new CustomEditColumn('Isi', 'isi', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for harga field
            //
            $editor = new TextEdit('harga_edit');
            $editColumn = new CustomEditColumn('Harga', 'harga', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for jumlah field
            //
            $editor = new TextEdit('jumlah_edit');
            $editColumn = new CustomEditColumn('Jumlah', 'jumlah', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for diskon field
            //
            $editor = new TextEdit('diskon_edit');
            $editColumn = new CustomEditColumn('Diskon', 'diskon', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for diskon2 field
            //
            $editor = new TextEdit('diskon2_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Diskon2', 'diskon2', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for biaya field
            //
            $editor = new TextEdit('biaya_edit');
            $editColumn = new CustomEditColumn('Biaya', 'biaya', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for total field
            //
            $editor = new TextEdit('total_edit');
            $editColumn = new CustomEditColumn('Total', 'total', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for idx field
            //
            $editor = new TextEdit('idx_edit');
            $editor->SetMaxLength(60);
            $editColumn = new CustomEditColumn('Idx', 'idx', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for notrans field
            //
            $editor = new DynamicCombobox('notrans_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tr`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('notrans', true),
                    new StringField('kdpc'),
                    new StringField('kdtrans', true),
                    new IntegerField('nobukti'),
                    new DateTimeField('tanggal', true),
                    new IntegerField('idkontak'),
                    new StringField('tipe'),
                    new IntegerField('nilai'),
                    new IntegerField('norek'),
                    new StringField('operator'),
                    new StringField('keterangan'),
                    new IntegerField('idpegawai'),
                    new IntegerField('dihapus')
                )
            );
            $lookupDataset->setOrderByField('id', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Notrans', 'notrans', 'notrans_id', 'multi_edit_brg_trd_notrans_search', $editor, $this->dataset, $lookupDataset, 'notrans', 'id', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for idtrans field
            //
            $editor = new DynamicCombobox('idtrans_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tr`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('notrans', true),
                    new StringField('kdpc'),
                    new StringField('kdtrans', true),
                    new IntegerField('nobukti'),
                    new DateTimeField('tanggal', true),
                    new IntegerField('idkontak'),
                    new StringField('tipe'),
                    new IntegerField('nilai'),
                    new IntegerField('norek'),
                    new StringField('operator'),
                    new StringField('keterangan'),
                    new IntegerField('idpegawai'),
                    new IntegerField('dihapus')
                )
            );
            $lookupDataset->setOrderByField('notrans', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Idtrans', 'idtrans', 'idtrans_notrans', 'multi_edit_brg_trd_idtrans_search', $editor, $this->dataset, $lookupDataset, 'id', 'notrans', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for idbarang field
            //
            $editor = new DynamicCombobox('idbarang_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('idgol', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Idbarang', 'idbarang', 'idbarang_idgol', 'multi_edit_brg_trd_idbarang_search', $editor, $this->dataset, $lookupDataset, 'id', 'idgol', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for tipe field
            //
            $editor = new TextEdit('tipe_edit');
            $editor->SetMaxLength(10);
            $editColumn = new CustomEditColumn('Tipe', 'tipe', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for kode field
            //
            $editor = new DynamicCombobox('kode_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('id', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Kode', 'kode', 'kode_id', 'multi_edit_brg_trd_kode_search', $editor, $this->dataset, $lookupDataset, 'kode', 'id', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for qtynota field
            //
            $editor = new TextEdit('qtynota_edit');
            $editColumn = new CustomEditColumn('Qtynota', 'qtynota', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for idsatuan field
            //
            $editor = new DynamicCombobox('idsatuan_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`satuan`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('satuan', true)
                )
            );
            $lookupDataset->setOrderByField('satuan', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Idsatuan', 'idsatuan', 'idsatuan_satuan', 'multi_edit_brg_trd_idsatuan_search', $editor, $this->dataset, $lookupDataset, 'id', 'satuan', '');
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for isi field
            //
            $editor = new TextEdit('isi_edit');
            $editColumn = new CustomEditColumn('Isi', 'isi', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for harga field
            //
            $editor = new TextEdit('harga_edit');
            $editColumn = new CustomEditColumn('Harga', 'harga', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for jumlah field
            //
            $editor = new TextEdit('jumlah_edit');
            $editColumn = new CustomEditColumn('Jumlah', 'jumlah', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for diskon field
            //
            $editor = new TextEdit('diskon_edit');
            $editColumn = new CustomEditColumn('Diskon', 'diskon', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for diskon2 field
            //
            $editor = new TextEdit('diskon2_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Diskon2', 'diskon2', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for biaya field
            //
            $editor = new TextEdit('biaya_edit');
            $editColumn = new CustomEditColumn('Biaya', 'biaya', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for total field
            //
            $editor = new TextEdit('total_edit');
            $editColumn = new CustomEditColumn('Total', 'total', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for idx field
            //
            $editor = new TextEdit('idx_edit');
            $editor->SetMaxLength(60);
            $editColumn = new CustomEditColumn('Idx', 'idx', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for id field
            //
            $editor = new TextEdit('id_edit');
            $editor->SetMaxLength(60);
            $editColumn = new CustomEditColumn('Id', 'id', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for notrans field
            //
            $editor = new DynamicCombobox('notrans_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tr`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('notrans', true),
                    new StringField('kdpc'),
                    new StringField('kdtrans', true),
                    new IntegerField('nobukti'),
                    new DateTimeField('tanggal', true),
                    new IntegerField('idkontak'),
                    new StringField('tipe'),
                    new IntegerField('nilai'),
                    new IntegerField('norek'),
                    new StringField('operator'),
                    new StringField('keterangan'),
                    new IntegerField('idpegawai'),
                    new IntegerField('dihapus')
                )
            );
            $lookupDataset->setOrderByField('id', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Notrans', 'notrans', 'notrans_id', 'insert_brg_trd_notrans_search', $editor, $this->dataset, $lookupDataset, 'notrans', 'id', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for idtrans field
            //
            $editor = new DynamicCombobox('idtrans_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tr`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('notrans', true),
                    new StringField('kdpc'),
                    new StringField('kdtrans', true),
                    new IntegerField('nobukti'),
                    new DateTimeField('tanggal', true),
                    new IntegerField('idkontak'),
                    new StringField('tipe'),
                    new IntegerField('nilai'),
                    new IntegerField('norek'),
                    new StringField('operator'),
                    new StringField('keterangan'),
                    new IntegerField('idpegawai'),
                    new IntegerField('dihapus')
                )
            );
            $lookupDataset->setOrderByField('notrans', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Idtrans', 'idtrans', 'idtrans_notrans', 'insert_brg_trd_idtrans_search', $editor, $this->dataset, $lookupDataset, 'id', 'notrans', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for idbarang field
            //
            $editor = new DynamicCombobox('idbarang_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('idgol', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Idbarang', 'idbarang', 'idbarang_idgol', 'insert_brg_trd_idbarang_search', $editor, $this->dataset, $lookupDataset, 'id', 'idgol', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for tipe field
            //
            $editor = new TextEdit('tipe_edit');
            $editor->SetMaxLength(10);
            $editColumn = new CustomEditColumn('Tipe', 'tipe', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for kode field
            //
            $editor = new DynamicCombobox('kode_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('id', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Kode', 'kode', 'kode_id', 'insert_brg_trd_kode_search', $editor, $this->dataset, $lookupDataset, 'kode', 'id', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for qtynota field
            //
            $editor = new TextEdit('qtynota_edit');
            $editColumn = new CustomEditColumn('Qtynota', 'qtynota', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for idsatuan field
            //
            $editor = new DynamicCombobox('idsatuan_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`satuan`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('satuan', true)
                )
            );
            $lookupDataset->setOrderByField('satuan', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Idsatuan', 'idsatuan', 'idsatuan_satuan', 'insert_brg_trd_idsatuan_search', $editor, $this->dataset, $lookupDataset, 'id', 'satuan', '');
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for isi field
            //
            $editor = new TextEdit('isi_edit');
            $editColumn = new CustomEditColumn('Isi', 'isi', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for harga field
            //
            $editor = new TextEdit('harga_edit');
            $editColumn = new CustomEditColumn('Harga', 'harga', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for jumlah field
            //
            $editor = new TextEdit('jumlah_edit');
            $editColumn = new CustomEditColumn('Jumlah', 'jumlah', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for diskon field
            //
            $editor = new TextEdit('diskon_edit');
            $editColumn = new CustomEditColumn('Diskon', 'diskon', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for diskon2 field
            //
            $editor = new TextEdit('diskon2_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Diskon2', 'diskon2', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for biaya field
            //
            $editor = new TextEdit('biaya_edit');
            $editColumn = new CustomEditColumn('Biaya', 'biaya', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for total field
            //
            $editor = new TextEdit('total_edit');
            $editColumn = new CustomEditColumn('Total', 'total', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for idx field
            //
            $editor = new TextEdit('idx_edit');
            $editor->SetMaxLength(60);
            $editColumn = new CustomEditColumn('Idx', 'idx', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            $grid->SetShowAddButton(true && $this->GetSecurityInfo()->HasAddGrant());
        }
    
        private function AddMultiUploadColumn(Grid $grid)
        {
    
        }
    
        protected function AddPrintColumns(Grid $grid)
        {
            //
            // View column for id field
            //
            $column = new TextViewColumn('id', 'id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for id field
            //
            $column = new NumberViewColumn('notrans', 'notrans_id', 'Notrans', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for notrans field
            //
            $column = new TextViewColumn('idtrans', 'idtrans_notrans', 'Idtrans', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for idgol field
            //
            $column = new NumberViewColumn('idbarang', 'idbarang_idgol', 'Idbarang', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for tipe field
            //
            $column = new TextViewColumn('tipe', 'tipe', 'Tipe', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for id field
            //
            $column = new NumberViewColumn('kode', 'kode_id', 'Kode', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for qtynota field
            //
            $column = new NumberViewColumn('qtynota', 'qtynota', 'Qtynota', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddPrintColumn($column);
            
            //
            // View column for satuan field
            //
            $column = new TextViewColumn('idsatuan', 'idsatuan_satuan', 'Idsatuan', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for isi field
            //
            $column = new NumberViewColumn('isi', 'isi', 'Isi', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddPrintColumn($column);
            
            //
            // View column for harga field
            //
            $column = new NumberViewColumn('harga', 'harga', 'Harga', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddPrintColumn($column);
            
            //
            // View column for jumlah field
            //
            $column = new NumberViewColumn('jumlah', 'jumlah', 'Jumlah', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddPrintColumn($column);
            
            //
            // View column for diskon field
            //
            $column = new NumberViewColumn('diskon', 'diskon', 'Diskon', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddPrintColumn($column);
            
            //
            // View column for diskon2 field
            //
            $column = new TextViewColumn('diskon2', 'diskon2', 'Diskon2', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for biaya field
            //
            $column = new NumberViewColumn('biaya', 'biaya', 'Biaya', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddPrintColumn($column);
            
            //
            // View column for total field
            //
            $column = new NumberViewColumn('total', 'total', 'Total', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddPrintColumn($column);
            
            //
            // View column for idx field
            //
            $column = new TextViewColumn('idx', 'idx', 'Idx', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for id field
            //
            $column = new TextViewColumn('id', 'id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for id field
            //
            $column = new NumberViewColumn('notrans', 'notrans_id', 'Notrans', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for notrans field
            //
            $column = new TextViewColumn('idtrans', 'idtrans_notrans', 'Idtrans', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for idgol field
            //
            $column = new NumberViewColumn('idbarang', 'idbarang_idgol', 'Idbarang', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for tipe field
            //
            $column = new TextViewColumn('tipe', 'tipe', 'Tipe', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for id field
            //
            $column = new NumberViewColumn('kode', 'kode_id', 'Kode', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for qtynota field
            //
            $column = new NumberViewColumn('qtynota', 'qtynota', 'Qtynota', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddExportColumn($column);
            
            //
            // View column for satuan field
            //
            $column = new TextViewColumn('idsatuan', 'idsatuan_satuan', 'Idsatuan', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for isi field
            //
            $column = new NumberViewColumn('isi', 'isi', 'Isi', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddExportColumn($column);
            
            //
            // View column for harga field
            //
            $column = new NumberViewColumn('harga', 'harga', 'Harga', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddExportColumn($column);
            
            //
            // View column for jumlah field
            //
            $column = new NumberViewColumn('jumlah', 'jumlah', 'Jumlah', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddExportColumn($column);
            
            //
            // View column for diskon field
            //
            $column = new NumberViewColumn('diskon', 'diskon', 'Diskon', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddExportColumn($column);
            
            //
            // View column for diskon2 field
            //
            $column = new TextViewColumn('diskon2', 'diskon2', 'Diskon2', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for biaya field
            //
            $column = new NumberViewColumn('biaya', 'biaya', 'Biaya', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddExportColumn($column);
            
            //
            // View column for total field
            //
            $column = new NumberViewColumn('total', 'total', 'Total', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddExportColumn($column);
            
            //
            // View column for idx field
            //
            $column = new TextViewColumn('idx', 'idx', 'Idx', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for id field
            //
            $column = new TextViewColumn('id', 'id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for id field
            //
            $column = new NumberViewColumn('notrans', 'notrans_id', 'Notrans', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for notrans field
            //
            $column = new TextViewColumn('idtrans', 'idtrans_notrans', 'Idtrans', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for idgol field
            //
            $column = new NumberViewColumn('idbarang', 'idbarang_idgol', 'Idbarang', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for tipe field
            //
            $column = new TextViewColumn('tipe', 'tipe', 'Tipe', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for id field
            //
            $column = new NumberViewColumn('kode', 'kode_id', 'Kode', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for qtynota field
            //
            $column = new NumberViewColumn('qtynota', 'qtynota', 'Qtynota', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddCompareColumn($column);
            
            //
            // View column for satuan field
            //
            $column = new TextViewColumn('idsatuan', 'idsatuan_satuan', 'Idsatuan', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for isi field
            //
            $column = new NumberViewColumn('isi', 'isi', 'Isi', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddCompareColumn($column);
            
            //
            // View column for harga field
            //
            $column = new NumberViewColumn('harga', 'harga', 'Harga', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddCompareColumn($column);
            
            //
            // View column for jumlah field
            //
            $column = new NumberViewColumn('jumlah', 'jumlah', 'Jumlah', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddCompareColumn($column);
            
            //
            // View column for diskon field
            //
            $column = new NumberViewColumn('diskon', 'diskon', 'Diskon', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddCompareColumn($column);
            
            //
            // View column for diskon2 field
            //
            $column = new TextViewColumn('diskon2', 'diskon2', 'Diskon2', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for biaya field
            //
            $column = new NumberViewColumn('biaya', 'biaya', 'Biaya', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddCompareColumn($column);
            
            //
            // View column for total field
            //
            $column = new NumberViewColumn('total', 'total', 'Total', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddCompareColumn($column);
            
            //
            // View column for idx field
            //
            $column = new TextViewColumn('idx', 'idx', 'Idx', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
        }
    
        private function AddCompareHeaderColumns(Grid $grid)
        {
    
        }
    
        public function GetPageDirection()
        {
            return null;
        }
    
        public function isFilterConditionRequired()
        {
            return false;
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetDisplaySetToNullCheckBox(false);
            $column->SetDisplaySetToDefaultCheckBox(false);
    		$column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
        
        public function GetEnableModalGridInsert() { return true; }
        public function GetEnableModalGridEdit() { return true; }
        
        protected function GetEnableModalGridDelete() { return true; }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset);
            if ($this->GetSecurityInfo()->HasDeleteGrant())
               $result->SetAllowDeleteSelected(true);
            else
               $result->SetAllowDeleteSelected(false);   
            
            ApplyCommonPageSettings($this, $result);
            
            $result->SetUseImagesForActions(true);
            $result->SetUseFixedHeader(false);
            $result->SetShowLineNumbers(true);
            $result->SetViewMode(ViewMode::TABLE);
            $result->setEnableRuntimeCustomization(true);
            $result->setAllowCompare(true);
            $this->AddCompareHeaderColumns($result);
            $this->AddCompareColumns($result);
            $result->setMultiEditAllowed($this->GetSecurityInfo()->HasEditGrant() && true);
            $result->setTableBordered(false);
            $result->setTableCondensed(false);
            
            $result->SetHighlightRowAtHover(true);
            $result->SetWidth('');
            $this->AddOperationsColumns($result);
            $this->AddFieldColumns($result);
            $this->AddSingleRecordViewColumns($result);
            $this->AddEditColumns($result);
            $this->AddMultiEditColumns($result);
            $this->AddInsertColumns($result);
            $this->AddPrintColumns($result);
            $this->AddExportColumns($result);
            $this->AddMultiUploadColumn($result);
    
    
            $this->SetShowPageList(true);
            $this->SetShowTopPageNavigator(true);
            $this->SetShowBottomPageNavigator(true);
            $this->setPrintListAvailable(true);
            $this->setPrintListRecordAvailable(false);
            $this->setPrintOneRecordAvailable(true);
            $this->setAllowPrintSelectedRecords(true);
            $this->setExportListAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportSelectedRecordsAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportListRecordAvailable(array());
            $this->setExportOneRecordAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
    
            return $result;
        }
     
        protected function setClientSideEvents(Grid $grid) {
    
        }
    
        protected function doRegisterHandlers() {
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tr`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('notrans', true),
                    new StringField('kdpc'),
                    new StringField('kdtrans', true),
                    new IntegerField('nobukti'),
                    new DateTimeField('tanggal', true),
                    new IntegerField('idkontak'),
                    new StringField('tipe'),
                    new IntegerField('nilai'),
                    new IntegerField('norek'),
                    new StringField('operator'),
                    new StringField('keterangan'),
                    new IntegerField('idpegawai'),
                    new IntegerField('dihapus')
                )
            );
            $lookupDataset->setOrderByField('id', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_brg_trd_notrans_search', 'notrans', 'id', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tr`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('notrans', true),
                    new StringField('kdpc'),
                    new StringField('kdtrans', true),
                    new IntegerField('nobukti'),
                    new DateTimeField('tanggal', true),
                    new IntegerField('idkontak'),
                    new StringField('tipe'),
                    new IntegerField('nilai'),
                    new IntegerField('norek'),
                    new StringField('operator'),
                    new StringField('keterangan'),
                    new IntegerField('idpegawai'),
                    new IntegerField('dihapus')
                )
            );
            $lookupDataset->setOrderByField('notrans', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_brg_trd_idtrans_search', 'id', 'notrans', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('idgol', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_brg_trd_idbarang_search', 'id', 'idgol', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('id', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_brg_trd_kode_search', 'kode', 'id', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`satuan`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('satuan', true)
                )
            );
            $lookupDataset->setOrderByField('satuan', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_brg_trd_idsatuan_search', 'id', 'satuan', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tr`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('notrans', true),
                    new StringField('kdpc'),
                    new StringField('kdtrans', true),
                    new IntegerField('nobukti'),
                    new DateTimeField('tanggal', true),
                    new IntegerField('idkontak'),
                    new StringField('tipe'),
                    new IntegerField('nilai'),
                    new IntegerField('norek'),
                    new StringField('operator'),
                    new StringField('keterangan'),
                    new IntegerField('idpegawai'),
                    new IntegerField('dihapus')
                )
            );
            $lookupDataset->setOrderByField('id', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_brg_trd_notrans_search', 'notrans', 'id', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tr`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('notrans', true),
                    new StringField('kdpc'),
                    new StringField('kdtrans', true),
                    new IntegerField('nobukti'),
                    new DateTimeField('tanggal', true),
                    new IntegerField('idkontak'),
                    new StringField('tipe'),
                    new IntegerField('nilai'),
                    new IntegerField('norek'),
                    new StringField('operator'),
                    new StringField('keterangan'),
                    new IntegerField('idpegawai'),
                    new IntegerField('dihapus')
                )
            );
            $lookupDataset->setOrderByField('notrans', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_brg_trd_idtrans_search', 'id', 'notrans', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('idgol', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_brg_trd_idbarang_search', 'id', 'idgol', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('id', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_brg_trd_kode_search', 'kode', 'id', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`satuan`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('satuan', true)
                )
            );
            $lookupDataset->setOrderByField('satuan', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_brg_trd_idsatuan_search', 'id', 'satuan', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tr`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('notrans', true),
                    new StringField('kdpc'),
                    new StringField('kdtrans', true),
                    new IntegerField('nobukti'),
                    new DateTimeField('tanggal', true),
                    new IntegerField('idkontak'),
                    new StringField('tipe'),
                    new IntegerField('nilai'),
                    new IntegerField('norek'),
                    new StringField('operator'),
                    new StringField('keterangan'),
                    new IntegerField('idpegawai'),
                    new IntegerField('dihapus')
                )
            );
            $lookupDataset->setOrderByField('id', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_brg_trd_notrans_search', 'notrans', 'id', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tr`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('notrans', true),
                    new StringField('kdpc'),
                    new StringField('kdtrans', true),
                    new IntegerField('nobukti'),
                    new DateTimeField('tanggal', true),
                    new IntegerField('idkontak'),
                    new StringField('tipe'),
                    new IntegerField('nilai'),
                    new IntegerField('norek'),
                    new StringField('operator'),
                    new StringField('keterangan'),
                    new IntegerField('idpegawai'),
                    new IntegerField('dihapus')
                )
            );
            $lookupDataset->setOrderByField('notrans', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_brg_trd_idtrans_search', 'id', 'notrans', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('idgol', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_brg_trd_idbarang_search', 'id', 'idgol', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('id', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_brg_trd_kode_search', 'kode', 'id', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`satuan`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('satuan', true)
                )
            );
            $lookupDataset->setOrderByField('satuan', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_brg_trd_idsatuan_search', 'id', 'satuan', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tr`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('notrans', true),
                    new StringField('kdpc'),
                    new StringField('kdtrans', true),
                    new IntegerField('nobukti'),
                    new DateTimeField('tanggal', true),
                    new IntegerField('idkontak'),
                    new StringField('tipe'),
                    new IntegerField('nilai'),
                    new IntegerField('norek'),
                    new StringField('operator'),
                    new StringField('keterangan'),
                    new IntegerField('idpegawai'),
                    new IntegerField('dihapus')
                )
            );
            $lookupDataset->setOrderByField('id', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_brg_trd_notrans_search', 'notrans', 'id', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tr`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('notrans', true),
                    new StringField('kdpc'),
                    new StringField('kdtrans', true),
                    new IntegerField('nobukti'),
                    new DateTimeField('tanggal', true),
                    new IntegerField('idkontak'),
                    new StringField('tipe'),
                    new IntegerField('nilai'),
                    new IntegerField('norek'),
                    new StringField('operator'),
                    new StringField('keterangan'),
                    new IntegerField('idpegawai'),
                    new IntegerField('dihapus')
                )
            );
            $lookupDataset->setOrderByField('notrans', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_brg_trd_idtrans_search', 'id', 'notrans', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('idgol', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_brg_trd_idbarang_search', 'id', 'idgol', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('id', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_brg_trd_kode_search', 'kode', 'id', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`satuan`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('satuan', true)
                )
            );
            $lookupDataset->setOrderByField('satuan', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_brg_trd_idsatuan_search', 'id', 'satuan', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
        }
       
        protected function doCustomRenderColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderPrintColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderExportColumn($exportType, $fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomDrawRow($rowData, &$cellFontColor, &$cellFontSize, &$cellBgColor, &$cellItalicAttr, &$cellBoldAttr)
        {
    
        }
    
        protected function doExtendedCustomDrawRow($rowData, &$rowCellStyles, &$rowStyles, &$rowClasses, &$cellClasses)
        {
    
        }
    
        protected function doCustomRenderTotal($totalValue, $aggregate, $columnName, &$customText, &$handled)
        {
    
        }
    
        protected function doCustomDefaultValues(&$values, &$handled) 
        {
    
        }
    
        protected function doCustomCompareColumn($columnName, $valueA, $valueB, &$result)
        {
    
        }
    
        protected function doBeforeInsertRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doBeforeUpdateRecord($page, $oldRowData, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doBeforeDeleteRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterInsertRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterUpdateRecord($page, $oldRowData, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterDeleteRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doCustomHTMLHeader($page, &$customHtmlHeaderText)
        { 
    
        }
    
        protected function doGetCustomTemplate($type, $part, $mode, &$result, &$params)
        {
    
        }
    
        protected function doGetCustomExportOptions(Page $page, $exportType, $rowData, &$options)
        {
    
        }
    
        protected function doFileUpload($fieldName, $rowData, &$result, &$accept, $originalFileName, $originalFileExtension, $fileSize, $tempFileName)
        {
    
        }
    
        protected function doPrepareChart(Chart $chart)
        {
    
        }
    
        protected function doPrepareColumnFilter(ColumnFilter $columnFilter)
        {
    
        }
    
        protected function doPrepareFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
    
        }
    
        protected function doGetSelectionFilters(FixedKeysArray $columns, &$result)
        {
    
        }
    
        protected function doGetCustomFormLayout($mode, FixedKeysArray $columns, FormLayout $layout)
        {
    
        }
    
        protected function doGetCustomColumnGroup(FixedKeysArray $columns, ViewColumnGroup $columnGroup)
        {
    
        }
    
        protected function doPageLoaded()
        {
    
        }
    
        protected function doCalculateFields($rowData, $fieldName, &$value)
        {
    
        }
    
        protected function doGetCustomRecordPermissions(Page $page, &$usingCondition, $rowData, &$allowEdit, &$allowDelete, &$mergeWithDefault, &$handled)
        {
    
        }
    
        protected function doAddEnvironmentVariables(Page $page, &$variables)
        {
    
        }
    
    }
    
    
    
    
    // OnBeforePageExecute event handler
    
    
    
    class brg_trd01Page extends DetailPage
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Trd');
            $this->SetMenuLabel('Trd');
            $this->SetHeader(GetPagesHeader());
            $this->SetFooter(GetPagesFooter());
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`trd`');
            $this->dataset->addFields(
                array(
                    new StringField('id', true, true),
                    new StringField('notrans', true),
                    new IntegerField('idtrans', true),
                    new IntegerField('idbarang', true),
                    new StringField('tipe'),
                    new StringField('kode', true),
                    new IntegerField('qtynota'),
                    new IntegerField('idsatuan'),
                    new IntegerField('isi'),
                    new IntegerField('harga'),
                    new IntegerField('jumlah'),
                    new IntegerField('diskon'),
                    new StringField('diskon2'),
                    new IntegerField('biaya'),
                    new IntegerField('total'),
                    new StringField('idx')
                )
            );
            $this->dataset->AddLookupField('notrans', 'tr', new StringField('notrans'), new IntegerField('id', false, false, false, false, 'notrans_id', 'notrans_id_tr'), 'notrans_id_tr');
            $this->dataset->AddLookupField('idtrans', 'tr', new IntegerField('id'), new StringField('notrans', false, false, false, false, 'idtrans_notrans', 'idtrans_notrans_tr'), 'idtrans_notrans_tr');
            $this->dataset->AddLookupField('idbarang', 'brg', new IntegerField('id'), new IntegerField('idgol', false, false, false, false, 'idbarang_idgol', 'idbarang_idgol_brg'), 'idbarang_idgol_brg');
            $this->dataset->AddLookupField('kode', 'brg', new StringField('kode'), new IntegerField('id', false, false, false, false, 'kode_id', 'kode_id_brg'), 'kode_id_brg');
            $this->dataset->AddLookupField('idsatuan', 'satuan', new IntegerField('id'), new StringField('satuan', false, false, false, false, 'idsatuan_satuan', 'idsatuan_satuan_satuan'), 'idsatuan_satuan_satuan');
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function CreatePageNavigator()
        {
            $result = new CompositePageNavigator($this);
            
            $partitionNavigator = new PageNavigator('pnav', $this, $this->dataset);
            $partitionNavigator->SetRowsPerPage(20);
            $result->AddPageNavigator($partitionNavigator);
            
            return $result;
        }
    
        protected function CreateRssGenerator()
        {
            return null;
        }
    
        protected function setupCharts()
        {
    
        }
    
        protected function getFiltersColumns()
        {
            return array(
                new FilterColumn($this->dataset, 'id', 'id', 'Id'),
                new FilterColumn($this->dataset, 'notrans', 'notrans_id', 'Notrans'),
                new FilterColumn($this->dataset, 'idtrans', 'idtrans_notrans', 'Idtrans'),
                new FilterColumn($this->dataset, 'idbarang', 'idbarang_idgol', 'Idbarang'),
                new FilterColumn($this->dataset, 'tipe', 'tipe', 'Tipe'),
                new FilterColumn($this->dataset, 'kode', 'kode_id', 'Kode'),
                new FilterColumn($this->dataset, 'qtynota', 'qtynota', 'Qtynota'),
                new FilterColumn($this->dataset, 'idsatuan', 'idsatuan_satuan', 'Idsatuan'),
                new FilterColumn($this->dataset, 'isi', 'isi', 'Isi'),
                new FilterColumn($this->dataset, 'harga', 'harga', 'Harga'),
                new FilterColumn($this->dataset, 'jumlah', 'jumlah', 'Jumlah'),
                new FilterColumn($this->dataset, 'diskon', 'diskon', 'Diskon'),
                new FilterColumn($this->dataset, 'diskon2', 'diskon2', 'Diskon2'),
                new FilterColumn($this->dataset, 'biaya', 'biaya', 'Biaya'),
                new FilterColumn($this->dataset, 'total', 'total', 'Total'),
                new FilterColumn($this->dataset, 'idx', 'idx', 'Idx')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['id'])
                ->addColumn($columns['notrans'])
                ->addColumn($columns['idtrans'])
                ->addColumn($columns['idbarang'])
                ->addColumn($columns['tipe'])
                ->addColumn($columns['kode'])
                ->addColumn($columns['qtynota'])
                ->addColumn($columns['idsatuan'])
                ->addColumn($columns['isi'])
                ->addColumn($columns['harga'])
                ->addColumn($columns['jumlah'])
                ->addColumn($columns['diskon'])
                ->addColumn($columns['diskon2'])
                ->addColumn($columns['biaya'])
                ->addColumn($columns['total'])
                ->addColumn($columns['idx']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('notrans')
                ->setOptionsFor('idtrans')
                ->setOptionsFor('idbarang')
                ->setOptionsFor('kode')
                ->setOptionsFor('idsatuan');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new TextEdit('id_edit');
            $main_editor->SetMaxLength(60);
            
            $filterBuilder->addColumn(
                $columns['id'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('notrans_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_brg_trd01_notrans_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('notrans', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_brg_trd01_notrans_search');
            
            $filterBuilder->addColumn(
                $columns['notrans'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('idtrans_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_brg_trd01_idtrans_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('idtrans', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_brg_trd01_idtrans_search');
            
            $text_editor = new TextEdit('idtrans');
            
            $filterBuilder->addColumn(
                $columns['idtrans'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('idbarang_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_brg_trd01_idbarang_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('idbarang', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_brg_trd01_idbarang_search');
            
            $filterBuilder->addColumn(
                $columns['idbarang'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('tipe_edit');
            $main_editor->SetMaxLength(10);
            
            $filterBuilder->addColumn(
                $columns['tipe'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('kode_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_brg_trd01_kode_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('kode', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_brg_trd01_kode_search');
            
            $filterBuilder->addColumn(
                $columns['kode'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('qtynota_edit');
            
            $filterBuilder->addColumn(
                $columns['qtynota'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('idsatuan_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_brg_trd01_idsatuan_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('idsatuan', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_brg_trd01_idsatuan_search');
            
            $text_editor = new TextEdit('idsatuan');
            
            $filterBuilder->addColumn(
                $columns['idsatuan'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('isi_edit');
            
            $filterBuilder->addColumn(
                $columns['isi'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('harga_edit');
            
            $filterBuilder->addColumn(
                $columns['harga'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('jumlah_edit');
            
            $filterBuilder->addColumn(
                $columns['jumlah'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('diskon_edit');
            
            $filterBuilder->addColumn(
                $columns['diskon'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('diskon2_edit');
            $main_editor->SetMaxLength(20);
            
            $filterBuilder->addColumn(
                $columns['diskon2'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('biaya_edit');
            
            $filterBuilder->addColumn(
                $columns['biaya'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('total_edit');
            
            $filterBuilder->addColumn(
                $columns['total'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('idx_edit');
            $main_editor->SetMaxLength(60);
            
            $filterBuilder->addColumn(
                $columns['idx'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
        }
    
        protected function AddOperationsColumns(Grid $grid)
        {
            $actions = $grid->getActions();
            $actions->setCaption($this->GetLocalizerCaptions()->GetMessageString('Actions'));
            $actions->setPosition(ActionList::POSITION_LEFT);
            
            if ($this->GetSecurityInfo()->HasViewGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('View'), OPERATION_VIEW, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
            
            if ($this->GetSecurityInfo()->HasEditGrant())
            {
                $operation = new AjaxOperation(OPERATION_EDIT,
                    $this->GetLocalizerCaptions()->GetMessageString('Edit'),
                    $this->GetLocalizerCaptions()->GetMessageString('Edit'), $this->dataset,
                    $this->GetGridEditHandler(), $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowEditButtonHandler', $this);
            }
            
            if ($this->GetSecurityInfo()->HasDeleteGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Delete'), OPERATION_DELETE, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowDeleteButtonHandler', $this);
                $operation->SetAdditionalAttribute('data-modal-operation', 'delete');
                $operation->SetAdditionalAttribute('data-delete-handler-name', $this->GetModalGridDeleteHandler());
            }
            
            if ($this->GetSecurityInfo()->HasAddGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Copy'), OPERATION_COPY, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
        }
    
        protected function AddFieldColumns(Grid $grid, $withDetails = true)
        {
            //
            // View column for id field
            //
            $column = new TextViewColumn('id', 'id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for id field
            //
            $column = new NumberViewColumn('notrans', 'notrans_id', 'Notrans', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for notrans field
            //
            $column = new TextViewColumn('idtrans', 'idtrans_notrans', 'Idtrans', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for idgol field
            //
            $column = new NumberViewColumn('idbarang', 'idbarang_idgol', 'Idbarang', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for tipe field
            //
            $column = new TextViewColumn('tipe', 'tipe', 'Tipe', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for id field
            //
            $column = new NumberViewColumn('kode', 'kode_id', 'Kode', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for qtynota field
            //
            $column = new NumberViewColumn('qtynota', 'qtynota', 'Qtynota', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for satuan field
            //
            $column = new TextViewColumn('idsatuan', 'idsatuan_satuan', 'Idsatuan', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for isi field
            //
            $column = new NumberViewColumn('isi', 'isi', 'Isi', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for harga field
            //
            $column = new NumberViewColumn('harga', 'harga', 'Harga', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for jumlah field
            //
            $column = new NumberViewColumn('jumlah', 'jumlah', 'Jumlah', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for diskon field
            //
            $column = new NumberViewColumn('diskon', 'diskon', 'Diskon', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for diskon2 field
            //
            $column = new TextViewColumn('diskon2', 'diskon2', 'Diskon2', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for biaya field
            //
            $column = new NumberViewColumn('biaya', 'biaya', 'Biaya', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for total field
            //
            $column = new NumberViewColumn('total', 'total', 'Total', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for idx field
            //
            $column = new TextViewColumn('idx', 'idx', 'Idx', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for id field
            //
            $column = new TextViewColumn('id', 'id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for id field
            //
            $column = new NumberViewColumn('notrans', 'notrans_id', 'Notrans', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for notrans field
            //
            $column = new TextViewColumn('idtrans', 'idtrans_notrans', 'Idtrans', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for idgol field
            //
            $column = new NumberViewColumn('idbarang', 'idbarang_idgol', 'Idbarang', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for tipe field
            //
            $column = new TextViewColumn('tipe', 'tipe', 'Tipe', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for id field
            //
            $column = new NumberViewColumn('kode', 'kode_id', 'Kode', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for qtynota field
            //
            $column = new NumberViewColumn('qtynota', 'qtynota', 'Qtynota', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for satuan field
            //
            $column = new TextViewColumn('idsatuan', 'idsatuan_satuan', 'Idsatuan', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for isi field
            //
            $column = new NumberViewColumn('isi', 'isi', 'Isi', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for harga field
            //
            $column = new NumberViewColumn('harga', 'harga', 'Harga', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for jumlah field
            //
            $column = new NumberViewColumn('jumlah', 'jumlah', 'Jumlah', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for diskon field
            //
            $column = new NumberViewColumn('diskon', 'diskon', 'Diskon', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for diskon2 field
            //
            $column = new TextViewColumn('diskon2', 'diskon2', 'Diskon2', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for biaya field
            //
            $column = new NumberViewColumn('biaya', 'biaya', 'Biaya', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for total field
            //
            $column = new NumberViewColumn('total', 'total', 'Total', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for idx field
            //
            $column = new TextViewColumn('idx', 'idx', 'Idx', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for id field
            //
            $editor = new TextEdit('id_edit');
            $editor->SetMaxLength(60);
            $editColumn = new CustomEditColumn('Id', 'id', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for notrans field
            //
            $editor = new DynamicCombobox('notrans_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tr`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('notrans', true),
                    new StringField('kdpc'),
                    new StringField('kdtrans', true),
                    new IntegerField('nobukti'),
                    new DateTimeField('tanggal', true),
                    new IntegerField('idkontak'),
                    new StringField('tipe'),
                    new IntegerField('nilai'),
                    new IntegerField('norek'),
                    new StringField('operator'),
                    new StringField('keterangan'),
                    new IntegerField('idpegawai'),
                    new IntegerField('dihapus')
                )
            );
            $lookupDataset->setOrderByField('id', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Notrans', 'notrans', 'notrans_id', 'edit_brg_trd01_notrans_search', $editor, $this->dataset, $lookupDataset, 'notrans', 'id', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for idtrans field
            //
            $editor = new DynamicCombobox('idtrans_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tr`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('notrans', true),
                    new StringField('kdpc'),
                    new StringField('kdtrans', true),
                    new IntegerField('nobukti'),
                    new DateTimeField('tanggal', true),
                    new IntegerField('idkontak'),
                    new StringField('tipe'),
                    new IntegerField('nilai'),
                    new IntegerField('norek'),
                    new StringField('operator'),
                    new StringField('keterangan'),
                    new IntegerField('idpegawai'),
                    new IntegerField('dihapus')
                )
            );
            $lookupDataset->setOrderByField('notrans', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Idtrans', 'idtrans', 'idtrans_notrans', 'edit_brg_trd01_idtrans_search', $editor, $this->dataset, $lookupDataset, 'id', 'notrans', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for idbarang field
            //
            $editor = new DynamicCombobox('idbarang_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('idgol', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Idbarang', 'idbarang', 'idbarang_idgol', 'edit_brg_trd01_idbarang_search', $editor, $this->dataset, $lookupDataset, 'id', 'idgol', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for tipe field
            //
            $editor = new TextEdit('tipe_edit');
            $editor->SetMaxLength(10);
            $editColumn = new CustomEditColumn('Tipe', 'tipe', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for kode field
            //
            $editor = new DynamicCombobox('kode_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('id', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Kode', 'kode', 'kode_id', 'edit_brg_trd01_kode_search', $editor, $this->dataset, $lookupDataset, 'kode', 'id', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for qtynota field
            //
            $editor = new TextEdit('qtynota_edit');
            $editColumn = new CustomEditColumn('Qtynota', 'qtynota', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for idsatuan field
            //
            $editor = new DynamicCombobox('idsatuan_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`satuan`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('satuan', true)
                )
            );
            $lookupDataset->setOrderByField('satuan', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Idsatuan', 'idsatuan', 'idsatuan_satuan', 'edit_brg_trd01_idsatuan_search', $editor, $this->dataset, $lookupDataset, 'id', 'satuan', '');
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for isi field
            //
            $editor = new TextEdit('isi_edit');
            $editColumn = new CustomEditColumn('Isi', 'isi', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for harga field
            //
            $editor = new TextEdit('harga_edit');
            $editColumn = new CustomEditColumn('Harga', 'harga', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for jumlah field
            //
            $editor = new TextEdit('jumlah_edit');
            $editColumn = new CustomEditColumn('Jumlah', 'jumlah', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for diskon field
            //
            $editor = new TextEdit('diskon_edit');
            $editColumn = new CustomEditColumn('Diskon', 'diskon', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for diskon2 field
            //
            $editor = new TextEdit('diskon2_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Diskon2', 'diskon2', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for biaya field
            //
            $editor = new TextEdit('biaya_edit');
            $editColumn = new CustomEditColumn('Biaya', 'biaya', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for total field
            //
            $editor = new TextEdit('total_edit');
            $editColumn = new CustomEditColumn('Total', 'total', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for idx field
            //
            $editor = new TextEdit('idx_edit');
            $editor->SetMaxLength(60);
            $editColumn = new CustomEditColumn('Idx', 'idx', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for notrans field
            //
            $editor = new DynamicCombobox('notrans_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tr`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('notrans', true),
                    new StringField('kdpc'),
                    new StringField('kdtrans', true),
                    new IntegerField('nobukti'),
                    new DateTimeField('tanggal', true),
                    new IntegerField('idkontak'),
                    new StringField('tipe'),
                    new IntegerField('nilai'),
                    new IntegerField('norek'),
                    new StringField('operator'),
                    new StringField('keterangan'),
                    new IntegerField('idpegawai'),
                    new IntegerField('dihapus')
                )
            );
            $lookupDataset->setOrderByField('id', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Notrans', 'notrans', 'notrans_id', 'multi_edit_brg_trd01_notrans_search', $editor, $this->dataset, $lookupDataset, 'notrans', 'id', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for idtrans field
            //
            $editor = new DynamicCombobox('idtrans_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tr`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('notrans', true),
                    new StringField('kdpc'),
                    new StringField('kdtrans', true),
                    new IntegerField('nobukti'),
                    new DateTimeField('tanggal', true),
                    new IntegerField('idkontak'),
                    new StringField('tipe'),
                    new IntegerField('nilai'),
                    new IntegerField('norek'),
                    new StringField('operator'),
                    new StringField('keterangan'),
                    new IntegerField('idpegawai'),
                    new IntegerField('dihapus')
                )
            );
            $lookupDataset->setOrderByField('notrans', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Idtrans', 'idtrans', 'idtrans_notrans', 'multi_edit_brg_trd01_idtrans_search', $editor, $this->dataset, $lookupDataset, 'id', 'notrans', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for idbarang field
            //
            $editor = new DynamicCombobox('idbarang_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('idgol', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Idbarang', 'idbarang', 'idbarang_idgol', 'multi_edit_brg_trd01_idbarang_search', $editor, $this->dataset, $lookupDataset, 'id', 'idgol', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for tipe field
            //
            $editor = new TextEdit('tipe_edit');
            $editor->SetMaxLength(10);
            $editColumn = new CustomEditColumn('Tipe', 'tipe', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for kode field
            //
            $editor = new DynamicCombobox('kode_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('id', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Kode', 'kode', 'kode_id', 'multi_edit_brg_trd01_kode_search', $editor, $this->dataset, $lookupDataset, 'kode', 'id', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for qtynota field
            //
            $editor = new TextEdit('qtynota_edit');
            $editColumn = new CustomEditColumn('Qtynota', 'qtynota', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for idsatuan field
            //
            $editor = new DynamicCombobox('idsatuan_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`satuan`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('satuan', true)
                )
            );
            $lookupDataset->setOrderByField('satuan', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Idsatuan', 'idsatuan', 'idsatuan_satuan', 'multi_edit_brg_trd01_idsatuan_search', $editor, $this->dataset, $lookupDataset, 'id', 'satuan', '');
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for isi field
            //
            $editor = new TextEdit('isi_edit');
            $editColumn = new CustomEditColumn('Isi', 'isi', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for harga field
            //
            $editor = new TextEdit('harga_edit');
            $editColumn = new CustomEditColumn('Harga', 'harga', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for jumlah field
            //
            $editor = new TextEdit('jumlah_edit');
            $editColumn = new CustomEditColumn('Jumlah', 'jumlah', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for diskon field
            //
            $editor = new TextEdit('diskon_edit');
            $editColumn = new CustomEditColumn('Diskon', 'diskon', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for diskon2 field
            //
            $editor = new TextEdit('diskon2_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Diskon2', 'diskon2', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for biaya field
            //
            $editor = new TextEdit('biaya_edit');
            $editColumn = new CustomEditColumn('Biaya', 'biaya', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for total field
            //
            $editor = new TextEdit('total_edit');
            $editColumn = new CustomEditColumn('Total', 'total', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for idx field
            //
            $editor = new TextEdit('idx_edit');
            $editor->SetMaxLength(60);
            $editColumn = new CustomEditColumn('Idx', 'idx', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for id field
            //
            $editor = new TextEdit('id_edit');
            $editor->SetMaxLength(60);
            $editColumn = new CustomEditColumn('Id', 'id', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for notrans field
            //
            $editor = new DynamicCombobox('notrans_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tr`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('notrans', true),
                    new StringField('kdpc'),
                    new StringField('kdtrans', true),
                    new IntegerField('nobukti'),
                    new DateTimeField('tanggal', true),
                    new IntegerField('idkontak'),
                    new StringField('tipe'),
                    new IntegerField('nilai'),
                    new IntegerField('norek'),
                    new StringField('operator'),
                    new StringField('keterangan'),
                    new IntegerField('idpegawai'),
                    new IntegerField('dihapus')
                )
            );
            $lookupDataset->setOrderByField('id', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Notrans', 'notrans', 'notrans_id', 'insert_brg_trd01_notrans_search', $editor, $this->dataset, $lookupDataset, 'notrans', 'id', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for idtrans field
            //
            $editor = new DynamicCombobox('idtrans_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tr`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('notrans', true),
                    new StringField('kdpc'),
                    new StringField('kdtrans', true),
                    new IntegerField('nobukti'),
                    new DateTimeField('tanggal', true),
                    new IntegerField('idkontak'),
                    new StringField('tipe'),
                    new IntegerField('nilai'),
                    new IntegerField('norek'),
                    new StringField('operator'),
                    new StringField('keterangan'),
                    new IntegerField('idpegawai'),
                    new IntegerField('dihapus')
                )
            );
            $lookupDataset->setOrderByField('notrans', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Idtrans', 'idtrans', 'idtrans_notrans', 'insert_brg_trd01_idtrans_search', $editor, $this->dataset, $lookupDataset, 'id', 'notrans', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for idbarang field
            //
            $editor = new DynamicCombobox('idbarang_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('idgol', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Idbarang', 'idbarang', 'idbarang_idgol', 'insert_brg_trd01_idbarang_search', $editor, $this->dataset, $lookupDataset, 'id', 'idgol', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for tipe field
            //
            $editor = new TextEdit('tipe_edit');
            $editor->SetMaxLength(10);
            $editColumn = new CustomEditColumn('Tipe', 'tipe', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for kode field
            //
            $editor = new DynamicCombobox('kode_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('id', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Kode', 'kode', 'kode_id', 'insert_brg_trd01_kode_search', $editor, $this->dataset, $lookupDataset, 'kode', 'id', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for qtynota field
            //
            $editor = new TextEdit('qtynota_edit');
            $editColumn = new CustomEditColumn('Qtynota', 'qtynota', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for idsatuan field
            //
            $editor = new DynamicCombobox('idsatuan_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`satuan`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('satuan', true)
                )
            );
            $lookupDataset->setOrderByField('satuan', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Idsatuan', 'idsatuan', 'idsatuan_satuan', 'insert_brg_trd01_idsatuan_search', $editor, $this->dataset, $lookupDataset, 'id', 'satuan', '');
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for isi field
            //
            $editor = new TextEdit('isi_edit');
            $editColumn = new CustomEditColumn('Isi', 'isi', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for harga field
            //
            $editor = new TextEdit('harga_edit');
            $editColumn = new CustomEditColumn('Harga', 'harga', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for jumlah field
            //
            $editor = new TextEdit('jumlah_edit');
            $editColumn = new CustomEditColumn('Jumlah', 'jumlah', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for diskon field
            //
            $editor = new TextEdit('diskon_edit');
            $editColumn = new CustomEditColumn('Diskon', 'diskon', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for diskon2 field
            //
            $editor = new TextEdit('diskon2_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Diskon2', 'diskon2', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for biaya field
            //
            $editor = new TextEdit('biaya_edit');
            $editColumn = new CustomEditColumn('Biaya', 'biaya', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for total field
            //
            $editor = new TextEdit('total_edit');
            $editColumn = new CustomEditColumn('Total', 'total', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for idx field
            //
            $editor = new TextEdit('idx_edit');
            $editor->SetMaxLength(60);
            $editColumn = new CustomEditColumn('Idx', 'idx', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            $grid->SetShowAddButton(true && $this->GetSecurityInfo()->HasAddGrant());
        }
    
        private function AddMultiUploadColumn(Grid $grid)
        {
    
        }
    
        protected function AddPrintColumns(Grid $grid)
        {
            //
            // View column for id field
            //
            $column = new TextViewColumn('id', 'id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for id field
            //
            $column = new NumberViewColumn('notrans', 'notrans_id', 'Notrans', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for notrans field
            //
            $column = new TextViewColumn('idtrans', 'idtrans_notrans', 'Idtrans', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for idgol field
            //
            $column = new NumberViewColumn('idbarang', 'idbarang_idgol', 'Idbarang', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for tipe field
            //
            $column = new TextViewColumn('tipe', 'tipe', 'Tipe', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for id field
            //
            $column = new NumberViewColumn('kode', 'kode_id', 'Kode', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for qtynota field
            //
            $column = new NumberViewColumn('qtynota', 'qtynota', 'Qtynota', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddPrintColumn($column);
            
            //
            // View column for satuan field
            //
            $column = new TextViewColumn('idsatuan', 'idsatuan_satuan', 'Idsatuan', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for isi field
            //
            $column = new NumberViewColumn('isi', 'isi', 'Isi', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddPrintColumn($column);
            
            //
            // View column for harga field
            //
            $column = new NumberViewColumn('harga', 'harga', 'Harga', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddPrintColumn($column);
            
            //
            // View column for jumlah field
            //
            $column = new NumberViewColumn('jumlah', 'jumlah', 'Jumlah', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddPrintColumn($column);
            
            //
            // View column for diskon field
            //
            $column = new NumberViewColumn('diskon', 'diskon', 'Diskon', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddPrintColumn($column);
            
            //
            // View column for diskon2 field
            //
            $column = new TextViewColumn('diskon2', 'diskon2', 'Diskon2', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for biaya field
            //
            $column = new NumberViewColumn('biaya', 'biaya', 'Biaya', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddPrintColumn($column);
            
            //
            // View column for total field
            //
            $column = new NumberViewColumn('total', 'total', 'Total', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddPrintColumn($column);
            
            //
            // View column for idx field
            //
            $column = new TextViewColumn('idx', 'idx', 'Idx', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for id field
            //
            $column = new TextViewColumn('id', 'id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for id field
            //
            $column = new NumberViewColumn('notrans', 'notrans_id', 'Notrans', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for notrans field
            //
            $column = new TextViewColumn('idtrans', 'idtrans_notrans', 'Idtrans', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for idgol field
            //
            $column = new NumberViewColumn('idbarang', 'idbarang_idgol', 'Idbarang', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for tipe field
            //
            $column = new TextViewColumn('tipe', 'tipe', 'Tipe', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for id field
            //
            $column = new NumberViewColumn('kode', 'kode_id', 'Kode', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for qtynota field
            //
            $column = new NumberViewColumn('qtynota', 'qtynota', 'Qtynota', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddExportColumn($column);
            
            //
            // View column for satuan field
            //
            $column = new TextViewColumn('idsatuan', 'idsatuan_satuan', 'Idsatuan', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for isi field
            //
            $column = new NumberViewColumn('isi', 'isi', 'Isi', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddExportColumn($column);
            
            //
            // View column for harga field
            //
            $column = new NumberViewColumn('harga', 'harga', 'Harga', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddExportColumn($column);
            
            //
            // View column for jumlah field
            //
            $column = new NumberViewColumn('jumlah', 'jumlah', 'Jumlah', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddExportColumn($column);
            
            //
            // View column for diskon field
            //
            $column = new NumberViewColumn('diskon', 'diskon', 'Diskon', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddExportColumn($column);
            
            //
            // View column for diskon2 field
            //
            $column = new TextViewColumn('diskon2', 'diskon2', 'Diskon2', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for biaya field
            //
            $column = new NumberViewColumn('biaya', 'biaya', 'Biaya', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddExportColumn($column);
            
            //
            // View column for total field
            //
            $column = new NumberViewColumn('total', 'total', 'Total', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddExportColumn($column);
            
            //
            // View column for idx field
            //
            $column = new TextViewColumn('idx', 'idx', 'Idx', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for id field
            //
            $column = new TextViewColumn('id', 'id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for id field
            //
            $column = new NumberViewColumn('notrans', 'notrans_id', 'Notrans', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for notrans field
            //
            $column = new TextViewColumn('idtrans', 'idtrans_notrans', 'Idtrans', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for idgol field
            //
            $column = new NumberViewColumn('idbarang', 'idbarang_idgol', 'Idbarang', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for tipe field
            //
            $column = new TextViewColumn('tipe', 'tipe', 'Tipe', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for id field
            //
            $column = new NumberViewColumn('kode', 'kode_id', 'Kode', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for qtynota field
            //
            $column = new NumberViewColumn('qtynota', 'qtynota', 'Qtynota', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddCompareColumn($column);
            
            //
            // View column for satuan field
            //
            $column = new TextViewColumn('idsatuan', 'idsatuan_satuan', 'Idsatuan', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for isi field
            //
            $column = new NumberViewColumn('isi', 'isi', 'Isi', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddCompareColumn($column);
            
            //
            // View column for harga field
            //
            $column = new NumberViewColumn('harga', 'harga', 'Harga', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddCompareColumn($column);
            
            //
            // View column for jumlah field
            //
            $column = new NumberViewColumn('jumlah', 'jumlah', 'Jumlah', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddCompareColumn($column);
            
            //
            // View column for diskon field
            //
            $column = new NumberViewColumn('diskon', 'diskon', 'Diskon', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddCompareColumn($column);
            
            //
            // View column for diskon2 field
            //
            $column = new TextViewColumn('diskon2', 'diskon2', 'Diskon2', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for biaya field
            //
            $column = new NumberViewColumn('biaya', 'biaya', 'Biaya', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddCompareColumn($column);
            
            //
            // View column for total field
            //
            $column = new NumberViewColumn('total', 'total', 'Total', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddCompareColumn($column);
            
            //
            // View column for idx field
            //
            $column = new TextViewColumn('idx', 'idx', 'Idx', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
        }
    
        private function AddCompareHeaderColumns(Grid $grid)
        {
    
        }
    
        public function GetPageDirection()
        {
            return null;
        }
    
        public function isFilterConditionRequired()
        {
            return false;
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetDisplaySetToNullCheckBox(false);
            $column->SetDisplaySetToDefaultCheckBox(false);
    		$column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
        
        public function GetEnableModalGridInsert() { return true; }
        public function GetEnableModalGridEdit() { return true; }
        
        protected function GetEnableModalGridDelete() { return true; }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset);
            if ($this->GetSecurityInfo()->HasDeleteGrant())
               $result->SetAllowDeleteSelected(true);
            else
               $result->SetAllowDeleteSelected(false);   
            
            ApplyCommonPageSettings($this, $result);
            
            $result->SetUseImagesForActions(true);
            $result->SetUseFixedHeader(false);
            $result->SetShowLineNumbers(true);
            $result->SetViewMode(ViewMode::TABLE);
            $result->setEnableRuntimeCustomization(true);
            $result->setAllowCompare(true);
            $this->AddCompareHeaderColumns($result);
            $this->AddCompareColumns($result);
            $result->setMultiEditAllowed($this->GetSecurityInfo()->HasEditGrant() && true);
            $result->setTableBordered(false);
            $result->setTableCondensed(false);
            
            $result->SetHighlightRowAtHover(true);
            $result->SetWidth('');
            $this->AddOperationsColumns($result);
            $this->AddFieldColumns($result);
            $this->AddSingleRecordViewColumns($result);
            $this->AddEditColumns($result);
            $this->AddMultiEditColumns($result);
            $this->AddInsertColumns($result);
            $this->AddPrintColumns($result);
            $this->AddExportColumns($result);
            $this->AddMultiUploadColumn($result);
    
    
            $this->SetShowPageList(true);
            $this->SetShowTopPageNavigator(true);
            $this->SetShowBottomPageNavigator(true);
            $this->setPrintListAvailable(true);
            $this->setPrintListRecordAvailable(false);
            $this->setPrintOneRecordAvailable(true);
            $this->setAllowPrintSelectedRecords(true);
            $this->setExportListAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportSelectedRecordsAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportListRecordAvailable(array());
            $this->setExportOneRecordAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
    
            return $result;
        }
     
        protected function setClientSideEvents(Grid $grid) {
    
        }
    
        protected function doRegisterHandlers() {
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tr`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('notrans', true),
                    new StringField('kdpc'),
                    new StringField('kdtrans', true),
                    new IntegerField('nobukti'),
                    new DateTimeField('tanggal', true),
                    new IntegerField('idkontak'),
                    new StringField('tipe'),
                    new IntegerField('nilai'),
                    new IntegerField('norek'),
                    new StringField('operator'),
                    new StringField('keterangan'),
                    new IntegerField('idpegawai'),
                    new IntegerField('dihapus')
                )
            );
            $lookupDataset->setOrderByField('id', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_brg_trd01_notrans_search', 'notrans', 'id', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tr`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('notrans', true),
                    new StringField('kdpc'),
                    new StringField('kdtrans', true),
                    new IntegerField('nobukti'),
                    new DateTimeField('tanggal', true),
                    new IntegerField('idkontak'),
                    new StringField('tipe'),
                    new IntegerField('nilai'),
                    new IntegerField('norek'),
                    new StringField('operator'),
                    new StringField('keterangan'),
                    new IntegerField('idpegawai'),
                    new IntegerField('dihapus')
                )
            );
            $lookupDataset->setOrderByField('notrans', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_brg_trd01_idtrans_search', 'id', 'notrans', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('idgol', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_brg_trd01_idbarang_search', 'id', 'idgol', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('id', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_brg_trd01_kode_search', 'kode', 'id', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`satuan`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('satuan', true)
                )
            );
            $lookupDataset->setOrderByField('satuan', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_brg_trd01_idsatuan_search', 'id', 'satuan', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tr`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('notrans', true),
                    new StringField('kdpc'),
                    new StringField('kdtrans', true),
                    new IntegerField('nobukti'),
                    new DateTimeField('tanggal', true),
                    new IntegerField('idkontak'),
                    new StringField('tipe'),
                    new IntegerField('nilai'),
                    new IntegerField('norek'),
                    new StringField('operator'),
                    new StringField('keterangan'),
                    new IntegerField('idpegawai'),
                    new IntegerField('dihapus')
                )
            );
            $lookupDataset->setOrderByField('id', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_brg_trd01_notrans_search', 'notrans', 'id', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tr`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('notrans', true),
                    new StringField('kdpc'),
                    new StringField('kdtrans', true),
                    new IntegerField('nobukti'),
                    new DateTimeField('tanggal', true),
                    new IntegerField('idkontak'),
                    new StringField('tipe'),
                    new IntegerField('nilai'),
                    new IntegerField('norek'),
                    new StringField('operator'),
                    new StringField('keterangan'),
                    new IntegerField('idpegawai'),
                    new IntegerField('dihapus')
                )
            );
            $lookupDataset->setOrderByField('notrans', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_brg_trd01_idtrans_search', 'id', 'notrans', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('idgol', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_brg_trd01_idbarang_search', 'id', 'idgol', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('id', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_brg_trd01_kode_search', 'kode', 'id', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`satuan`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('satuan', true)
                )
            );
            $lookupDataset->setOrderByField('satuan', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_brg_trd01_idsatuan_search', 'id', 'satuan', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tr`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('notrans', true),
                    new StringField('kdpc'),
                    new StringField('kdtrans', true),
                    new IntegerField('nobukti'),
                    new DateTimeField('tanggal', true),
                    new IntegerField('idkontak'),
                    new StringField('tipe'),
                    new IntegerField('nilai'),
                    new IntegerField('norek'),
                    new StringField('operator'),
                    new StringField('keterangan'),
                    new IntegerField('idpegawai'),
                    new IntegerField('dihapus')
                )
            );
            $lookupDataset->setOrderByField('id', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_brg_trd01_notrans_search', 'notrans', 'id', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tr`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('notrans', true),
                    new StringField('kdpc'),
                    new StringField('kdtrans', true),
                    new IntegerField('nobukti'),
                    new DateTimeField('tanggal', true),
                    new IntegerField('idkontak'),
                    new StringField('tipe'),
                    new IntegerField('nilai'),
                    new IntegerField('norek'),
                    new StringField('operator'),
                    new StringField('keterangan'),
                    new IntegerField('idpegawai'),
                    new IntegerField('dihapus')
                )
            );
            $lookupDataset->setOrderByField('notrans', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_brg_trd01_idtrans_search', 'id', 'notrans', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('idgol', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_brg_trd01_idbarang_search', 'id', 'idgol', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('id', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_brg_trd01_kode_search', 'kode', 'id', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`satuan`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('satuan', true)
                )
            );
            $lookupDataset->setOrderByField('satuan', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_brg_trd01_idsatuan_search', 'id', 'satuan', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tr`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('notrans', true),
                    new StringField('kdpc'),
                    new StringField('kdtrans', true),
                    new IntegerField('nobukti'),
                    new DateTimeField('tanggal', true),
                    new IntegerField('idkontak'),
                    new StringField('tipe'),
                    new IntegerField('nilai'),
                    new IntegerField('norek'),
                    new StringField('operator'),
                    new StringField('keterangan'),
                    new IntegerField('idpegawai'),
                    new IntegerField('dihapus')
                )
            );
            $lookupDataset->setOrderByField('id', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_brg_trd01_notrans_search', 'notrans', 'id', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tr`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('notrans', true),
                    new StringField('kdpc'),
                    new StringField('kdtrans', true),
                    new IntegerField('nobukti'),
                    new DateTimeField('tanggal', true),
                    new IntegerField('idkontak'),
                    new StringField('tipe'),
                    new IntegerField('nilai'),
                    new IntegerField('norek'),
                    new StringField('operator'),
                    new StringField('keterangan'),
                    new IntegerField('idpegawai'),
                    new IntegerField('dihapus')
                )
            );
            $lookupDataset->setOrderByField('notrans', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_brg_trd01_idtrans_search', 'id', 'notrans', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('idgol', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_brg_trd01_idbarang_search', 'id', 'idgol', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('id', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_brg_trd01_kode_search', 'kode', 'id', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`satuan`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('satuan', true)
                )
            );
            $lookupDataset->setOrderByField('satuan', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_brg_trd01_idsatuan_search', 'id', 'satuan', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
        }
       
        protected function doCustomRenderColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderPrintColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderExportColumn($exportType, $fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomDrawRow($rowData, &$cellFontColor, &$cellFontSize, &$cellBgColor, &$cellItalicAttr, &$cellBoldAttr)
        {
    
        }
    
        protected function doExtendedCustomDrawRow($rowData, &$rowCellStyles, &$rowStyles, &$rowClasses, &$cellClasses)
        {
    
        }
    
        protected function doCustomRenderTotal($totalValue, $aggregate, $columnName, &$customText, &$handled)
        {
    
        }
    
        protected function doCustomDefaultValues(&$values, &$handled) 
        {
    
        }
    
        protected function doCustomCompareColumn($columnName, $valueA, $valueB, &$result)
        {
    
        }
    
        protected function doBeforeInsertRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doBeforeUpdateRecord($page, $oldRowData, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doBeforeDeleteRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterInsertRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterUpdateRecord($page, $oldRowData, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterDeleteRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doCustomHTMLHeader($page, &$customHtmlHeaderText)
        { 
    
        }
    
        protected function doGetCustomTemplate($type, $part, $mode, &$result, &$params)
        {
    
        }
    
        protected function doGetCustomExportOptions(Page $page, $exportType, $rowData, &$options)
        {
    
        }
    
        protected function doFileUpload($fieldName, $rowData, &$result, &$accept, $originalFileName, $originalFileExtension, $fileSize, $tempFileName)
        {
    
        }
    
        protected function doPrepareChart(Chart $chart)
        {
    
        }
    
        protected function doPrepareColumnFilter(ColumnFilter $columnFilter)
        {
    
        }
    
        protected function doPrepareFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
    
        }
    
        protected function doGetSelectionFilters(FixedKeysArray $columns, &$result)
        {
    
        }
    
        protected function doGetCustomFormLayout($mode, FixedKeysArray $columns, FormLayout $layout)
        {
    
        }
    
        protected function doGetCustomColumnGroup(FixedKeysArray $columns, ViewColumnGroup $columnGroup)
        {
    
        }
    
        protected function doPageLoaded()
        {
    
        }
    
        protected function doCalculateFields($rowData, $fieldName, &$value)
        {
    
        }
    
        protected function doGetCustomRecordPermissions(Page $page, &$usingCondition, $rowData, &$allowEdit, &$allowDelete, &$mergeWithDefault, &$handled)
        {
    
        }
    
        protected function doAddEnvironmentVariables(Page $page, &$variables)
        {
    
        }
    
    }
    
    
    
    
    // OnBeforePageExecute event handler
    
    
    
    class brg_trdmutasiPage extends DetailPage
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Trdmutasi');
            $this->SetMenuLabel('Trdmutasi');
            $this->SetHeader(GetPagesHeader());
            $this->SetFooter(GetPagesFooter());
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`trdmutasi`');
            $this->dataset->addFields(
                array(
                    new StringField('id', true, true),
                    new StringField('refid'),
                    new IntegerField('idbarang'),
                    new IntegerField('qty'),
                    new IntegerField('debit'),
                    new IntegerField('mutasi'),
                    new IntegerField('retur'),
                    new IntegerField('terpakai'),
                    new IntegerField('sisa'),
                    new IntegerField('pesan'),
                    new IntegerField('proses'),
                    new IntegerField('gagal'),
                    new IntegerField('bahan'),
                    new IntegerField('diskonnota'),
                    new IntegerField('hpp'),
                    new IntegerField('hppbeli'),
                    new IntegerField('idlokasi'),
                    new IntegerField('idlokasi2'),
                    new IntegerField('cektr')
                )
            );
            $this->dataset->AddLookupField('id', 'trd', new StringField('id'), new StringField('notrans', false, false, false, false, 'id_notrans', 'id_notrans_trd'), 'id_notrans_trd');
            $this->dataset->AddLookupField('refid', 'trd', new StringField('id'), new StringField('notrans', false, false, false, false, 'refid_notrans', 'refid_notrans_trd'), 'refid_notrans_trd');
            $this->dataset->AddLookupField('idbarang', 'brg', new IntegerField('id'), new IntegerField('idgol', false, false, false, false, 'idbarang_idgol', 'idbarang_idgol_brg'), 'idbarang_idgol_brg');
            $this->dataset->AddLookupField('idlokasi', 'lokasi', new IntegerField('id'), new StringField('kode', false, false, false, false, 'idlokasi_kode', 'idlokasi_kode_lokasi'), 'idlokasi_kode_lokasi');
            $this->dataset->AddLookupField('idlokasi2', 'lokasi', new IntegerField('id'), new StringField('kode', false, false, false, false, 'idlokasi2_kode', 'idlokasi2_kode_lokasi'), 'idlokasi2_kode_lokasi');
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function CreatePageNavigator()
        {
            $result = new CompositePageNavigator($this);
            
            $partitionNavigator = new PageNavigator('pnav', $this, $this->dataset);
            $partitionNavigator->SetRowsPerPage(20);
            $result->AddPageNavigator($partitionNavigator);
            
            return $result;
        }
    
        protected function CreateRssGenerator()
        {
            return null;
        }
    
        protected function setupCharts()
        {
    
        }
    
        protected function getFiltersColumns()
        {
            return array(
                new FilterColumn($this->dataset, 'id', 'id_notrans', 'Id'),
                new FilterColumn($this->dataset, 'refid', 'refid_notrans', 'Refid'),
                new FilterColumn($this->dataset, 'idbarang', 'idbarang_idgol', 'Idbarang'),
                new FilterColumn($this->dataset, 'qty', 'qty', 'Qty'),
                new FilterColumn($this->dataset, 'debit', 'debit', 'Debit'),
                new FilterColumn($this->dataset, 'mutasi', 'mutasi', 'Mutasi'),
                new FilterColumn($this->dataset, 'retur', 'retur', 'Retur'),
                new FilterColumn($this->dataset, 'terpakai', 'terpakai', 'Terpakai'),
                new FilterColumn($this->dataset, 'sisa', 'sisa', 'Sisa'),
                new FilterColumn($this->dataset, 'pesan', 'pesan', 'Pesan'),
                new FilterColumn($this->dataset, 'proses', 'proses', 'Proses'),
                new FilterColumn($this->dataset, 'gagal', 'gagal', 'Gagal'),
                new FilterColumn($this->dataset, 'bahan', 'bahan', 'Bahan'),
                new FilterColumn($this->dataset, 'diskonnota', 'diskonnota', 'Diskonnota'),
                new FilterColumn($this->dataset, 'hpp', 'hpp', 'Hpp'),
                new FilterColumn($this->dataset, 'hppbeli', 'hppbeli', 'Hppbeli'),
                new FilterColumn($this->dataset, 'idlokasi', 'idlokasi_kode', 'Idlokasi'),
                new FilterColumn($this->dataset, 'idlokasi2', 'idlokasi2_kode', 'Idlokasi2'),
                new FilterColumn($this->dataset, 'cektr', 'cektr', 'Cektr')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['id'])
                ->addColumn($columns['refid'])
                ->addColumn($columns['idbarang'])
                ->addColumn($columns['qty'])
                ->addColumn($columns['debit'])
                ->addColumn($columns['mutasi'])
                ->addColumn($columns['retur'])
                ->addColumn($columns['terpakai'])
                ->addColumn($columns['sisa'])
                ->addColumn($columns['pesan'])
                ->addColumn($columns['proses'])
                ->addColumn($columns['gagal'])
                ->addColumn($columns['bahan'])
                ->addColumn($columns['diskonnota'])
                ->addColumn($columns['hpp'])
                ->addColumn($columns['hppbeli'])
                ->addColumn($columns['idlokasi'])
                ->addColumn($columns['idlokasi2'])
                ->addColumn($columns['cektr']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('id')
                ->setOptionsFor('refid')
                ->setOptionsFor('idbarang')
                ->setOptionsFor('idlokasi')
                ->setOptionsFor('idlokasi2');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new DynamicCombobox('id_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_brg_trdmutasi_id_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('id', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_brg_trdmutasi_id_search');
            
            $text_editor = new TextEdit('id');
            
            $filterBuilder->addColumn(
                $columns['id'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('refid_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_brg_trdmutasi_refid_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('refid', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_brg_trdmutasi_refid_search');
            
            $text_editor = new TextEdit('refid');
            
            $filterBuilder->addColumn(
                $columns['refid'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('idbarang_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_brg_trdmutasi_idbarang_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('idbarang', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_brg_trdmutasi_idbarang_search');
            
            $filterBuilder->addColumn(
                $columns['idbarang'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('qty_edit');
            
            $filterBuilder->addColumn(
                $columns['qty'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('debit_edit');
            
            $filterBuilder->addColumn(
                $columns['debit'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('mutasi_edit');
            
            $filterBuilder->addColumn(
                $columns['mutasi'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('retur_edit');
            
            $filterBuilder->addColumn(
                $columns['retur'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('terpakai_edit');
            
            $filterBuilder->addColumn(
                $columns['terpakai'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('sisa_edit');
            
            $filterBuilder->addColumn(
                $columns['sisa'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('pesan_edit');
            
            $filterBuilder->addColumn(
                $columns['pesan'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('proses_edit');
            
            $filterBuilder->addColumn(
                $columns['proses'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('gagal_edit');
            
            $filterBuilder->addColumn(
                $columns['gagal'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('bahan_edit');
            
            $filterBuilder->addColumn(
                $columns['bahan'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('diskonnota_edit');
            
            $filterBuilder->addColumn(
                $columns['diskonnota'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('hpp_edit');
            
            $filterBuilder->addColumn(
                $columns['hpp'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('hppbeli_edit');
            
            $filterBuilder->addColumn(
                $columns['hppbeli'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('idlokasi_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_brg_trdmutasi_idlokasi_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('idlokasi', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_brg_trdmutasi_idlokasi_search');
            
            $text_editor = new TextEdit('idlokasi');
            
            $filterBuilder->addColumn(
                $columns['idlokasi'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('idlokasi2_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_brg_trdmutasi_idlokasi2_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('idlokasi2', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_brg_trdmutasi_idlokasi2_search');
            
            $text_editor = new TextEdit('idlokasi2');
            
            $filterBuilder->addColumn(
                $columns['idlokasi2'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('cektr_edit');
            
            $filterBuilder->addColumn(
                $columns['cektr'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
        }
    
        protected function AddOperationsColumns(Grid $grid)
        {
            $actions = $grid->getActions();
            $actions->setCaption($this->GetLocalizerCaptions()->GetMessageString('Actions'));
            $actions->setPosition(ActionList::POSITION_LEFT);
            
            if ($this->GetSecurityInfo()->HasViewGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('View'), OPERATION_VIEW, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
            
            if ($this->GetSecurityInfo()->HasEditGrant())
            {
                $operation = new AjaxOperation(OPERATION_EDIT,
                    $this->GetLocalizerCaptions()->GetMessageString('Edit'),
                    $this->GetLocalizerCaptions()->GetMessageString('Edit'), $this->dataset,
                    $this->GetGridEditHandler(), $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowEditButtonHandler', $this);
            }
            
            if ($this->GetSecurityInfo()->HasDeleteGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Delete'), OPERATION_DELETE, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowDeleteButtonHandler', $this);
                $operation->SetAdditionalAttribute('data-modal-operation', 'delete');
                $operation->SetAdditionalAttribute('data-delete-handler-name', $this->GetModalGridDeleteHandler());
            }
            
            if ($this->GetSecurityInfo()->HasAddGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Copy'), OPERATION_COPY, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
        }
    
        protected function AddFieldColumns(Grid $grid, $withDetails = true)
        {
            //
            // View column for notrans field
            //
            $column = new TextViewColumn('id', 'id_notrans', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for notrans field
            //
            $column = new TextViewColumn('refid', 'refid_notrans', 'Refid', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for idgol field
            //
            $column = new NumberViewColumn('idbarang', 'idbarang_idgol', 'Idbarang', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for qty field
            //
            $column = new NumberViewColumn('qty', 'qty', 'Qty', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for debit field
            //
            $column = new NumberViewColumn('debit', 'debit', 'Debit', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for mutasi field
            //
            $column = new NumberViewColumn('mutasi', 'mutasi', 'Mutasi', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for retur field
            //
            $column = new NumberViewColumn('retur', 'retur', 'Retur', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for terpakai field
            //
            $column = new NumberViewColumn('terpakai', 'terpakai', 'Terpakai', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for sisa field
            //
            $column = new NumberViewColumn('sisa', 'sisa', 'Sisa', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for pesan field
            //
            $column = new NumberViewColumn('pesan', 'pesan', 'Pesan', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for proses field
            //
            $column = new NumberViewColumn('proses', 'proses', 'Proses', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for gagal field
            //
            $column = new NumberViewColumn('gagal', 'gagal', 'Gagal', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for bahan field
            //
            $column = new NumberViewColumn('bahan', 'bahan', 'Bahan', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for diskonnota field
            //
            $column = new NumberViewColumn('diskonnota', 'diskonnota', 'Diskonnota', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for hpp field
            //
            $column = new NumberViewColumn('hpp', 'hpp', 'Hpp', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for hppbeli field
            //
            $column = new NumberViewColumn('hppbeli', 'hppbeli', 'Hppbeli', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for kode field
            //
            $column = new TextViewColumn('idlokasi', 'idlokasi_kode', 'Idlokasi', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for kode field
            //
            $column = new TextViewColumn('idlokasi2', 'idlokasi2_kode', 'Idlokasi2', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for cektr field
            //
            $column = new NumberViewColumn('cektr', 'cektr', 'Cektr', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for notrans field
            //
            $column = new TextViewColumn('id', 'id_notrans', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for notrans field
            //
            $column = new TextViewColumn('refid', 'refid_notrans', 'Refid', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for idgol field
            //
            $column = new NumberViewColumn('idbarang', 'idbarang_idgol', 'Idbarang', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for qty field
            //
            $column = new NumberViewColumn('qty', 'qty', 'Qty', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for debit field
            //
            $column = new NumberViewColumn('debit', 'debit', 'Debit', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for mutasi field
            //
            $column = new NumberViewColumn('mutasi', 'mutasi', 'Mutasi', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for retur field
            //
            $column = new NumberViewColumn('retur', 'retur', 'Retur', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for terpakai field
            //
            $column = new NumberViewColumn('terpakai', 'terpakai', 'Terpakai', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for sisa field
            //
            $column = new NumberViewColumn('sisa', 'sisa', 'Sisa', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for pesan field
            //
            $column = new NumberViewColumn('pesan', 'pesan', 'Pesan', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for proses field
            //
            $column = new NumberViewColumn('proses', 'proses', 'Proses', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for gagal field
            //
            $column = new NumberViewColumn('gagal', 'gagal', 'Gagal', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for bahan field
            //
            $column = new NumberViewColumn('bahan', 'bahan', 'Bahan', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for diskonnota field
            //
            $column = new NumberViewColumn('diskonnota', 'diskonnota', 'Diskonnota', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for hpp field
            //
            $column = new NumberViewColumn('hpp', 'hpp', 'Hpp', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for hppbeli field
            //
            $column = new NumberViewColumn('hppbeli', 'hppbeli', 'Hppbeli', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for kode field
            //
            $column = new TextViewColumn('idlokasi', 'idlokasi_kode', 'Idlokasi', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for kode field
            //
            $column = new TextViewColumn('idlokasi2', 'idlokasi2_kode', 'Idlokasi2', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for cektr field
            //
            $column = new NumberViewColumn('cektr', 'cektr', 'Cektr', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for id field
            //
            $editor = new DynamicCombobox('id_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`trd`');
            $lookupDataset->addFields(
                array(
                    new StringField('id', true, true),
                    new StringField('notrans', true),
                    new IntegerField('idtrans', true),
                    new IntegerField('idbarang', true),
                    new StringField('tipe'),
                    new StringField('kode', true),
                    new IntegerField('qtynota'),
                    new IntegerField('idsatuan'),
                    new IntegerField('isi'),
                    new IntegerField('harga'),
                    new IntegerField('jumlah'),
                    new IntegerField('diskon'),
                    new StringField('diskon2'),
                    new IntegerField('biaya'),
                    new IntegerField('total'),
                    new StringField('idx')
                )
            );
            $lookupDataset->setOrderByField('notrans', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id', 'id', 'id_notrans', 'edit_brg_trdmutasi_id_search', $editor, $this->dataset, $lookupDataset, 'id', 'notrans', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for refid field
            //
            $editor = new DynamicCombobox('refid_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`trd`');
            $lookupDataset->addFields(
                array(
                    new StringField('id', true, true),
                    new StringField('notrans', true),
                    new IntegerField('idtrans', true),
                    new IntegerField('idbarang', true),
                    new StringField('tipe'),
                    new StringField('kode', true),
                    new IntegerField('qtynota'),
                    new IntegerField('idsatuan'),
                    new IntegerField('isi'),
                    new IntegerField('harga'),
                    new IntegerField('jumlah'),
                    new IntegerField('diskon'),
                    new StringField('diskon2'),
                    new IntegerField('biaya'),
                    new IntegerField('total'),
                    new StringField('idx')
                )
            );
            $lookupDataset->setOrderByField('notrans', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Refid', 'refid', 'refid_notrans', 'edit_brg_trdmutasi_refid_search', $editor, $this->dataset, $lookupDataset, 'id', 'notrans', '');
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for idbarang field
            //
            $editor = new DynamicCombobox('idbarang_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('idgol', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Idbarang', 'idbarang', 'idbarang_idgol', 'edit_brg_trdmutasi_idbarang_search', $editor, $this->dataset, $lookupDataset, 'id', 'idgol', '');
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for qty field
            //
            $editor = new TextEdit('qty_edit');
            $editColumn = new CustomEditColumn('Qty', 'qty', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for debit field
            //
            $editor = new TextEdit('debit_edit');
            $editColumn = new CustomEditColumn('Debit', 'debit', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for mutasi field
            //
            $editor = new TextEdit('mutasi_edit');
            $editColumn = new CustomEditColumn('Mutasi', 'mutasi', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for retur field
            //
            $editor = new TextEdit('retur_edit');
            $editColumn = new CustomEditColumn('Retur', 'retur', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for terpakai field
            //
            $editor = new TextEdit('terpakai_edit');
            $editColumn = new CustomEditColumn('Terpakai', 'terpakai', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for sisa field
            //
            $editor = new TextEdit('sisa_edit');
            $editColumn = new CustomEditColumn('Sisa', 'sisa', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for pesan field
            //
            $editor = new TextEdit('pesan_edit');
            $editColumn = new CustomEditColumn('Pesan', 'pesan', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for proses field
            //
            $editor = new TextEdit('proses_edit');
            $editColumn = new CustomEditColumn('Proses', 'proses', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for gagal field
            //
            $editor = new TextEdit('gagal_edit');
            $editColumn = new CustomEditColumn('Gagal', 'gagal', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for bahan field
            //
            $editor = new TextEdit('bahan_edit');
            $editColumn = new CustomEditColumn('Bahan', 'bahan', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for diskonnota field
            //
            $editor = new TextEdit('diskonnota_edit');
            $editColumn = new CustomEditColumn('Diskonnota', 'diskonnota', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for hpp field
            //
            $editor = new TextEdit('hpp_edit');
            $editColumn = new CustomEditColumn('Hpp', 'hpp', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for hppbeli field
            //
            $editor = new TextEdit('hppbeli_edit');
            $editColumn = new CustomEditColumn('Hppbeli', 'hppbeli', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for idlokasi field
            //
            $editor = new DynamicCombobox('idlokasi_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lokasi`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('alamat'),
                    new StringField('kota'),
                    new StringField('pimpinan'),
                    new StringField('telp'),
                    new StringField('fax'),
                    new IntegerField('aktif')
                )
            );
            $lookupDataset->setOrderByField('kode', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Idlokasi', 'idlokasi', 'idlokasi_kode', 'edit_brg_trdmutasi_idlokasi_search', $editor, $this->dataset, $lookupDataset, 'id', 'kode', '');
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for idlokasi2 field
            //
            $editor = new DynamicCombobox('idlokasi2_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lokasi`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('alamat'),
                    new StringField('kota'),
                    new StringField('pimpinan'),
                    new StringField('telp'),
                    new StringField('fax'),
                    new IntegerField('aktif')
                )
            );
            $lookupDataset->setOrderByField('kode', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Idlokasi2', 'idlokasi2', 'idlokasi2_kode', 'edit_brg_trdmutasi_idlokasi2_search', $editor, $this->dataset, $lookupDataset, 'id', 'kode', '');
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for cektr field
            //
            $editor = new TextEdit('cektr_edit');
            $editColumn = new CustomEditColumn('Cektr', 'cektr', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for refid field
            //
            $editor = new DynamicCombobox('refid_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`trd`');
            $lookupDataset->addFields(
                array(
                    new StringField('id', true, true),
                    new StringField('notrans', true),
                    new IntegerField('idtrans', true),
                    new IntegerField('idbarang', true),
                    new StringField('tipe'),
                    new StringField('kode', true),
                    new IntegerField('qtynota'),
                    new IntegerField('idsatuan'),
                    new IntegerField('isi'),
                    new IntegerField('harga'),
                    new IntegerField('jumlah'),
                    new IntegerField('diskon'),
                    new StringField('diskon2'),
                    new IntegerField('biaya'),
                    new IntegerField('total'),
                    new StringField('idx')
                )
            );
            $lookupDataset->setOrderByField('notrans', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Refid', 'refid', 'refid_notrans', 'multi_edit_brg_trdmutasi_refid_search', $editor, $this->dataset, $lookupDataset, 'id', 'notrans', '');
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for idbarang field
            //
            $editor = new DynamicCombobox('idbarang_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('idgol', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Idbarang', 'idbarang', 'idbarang_idgol', 'multi_edit_brg_trdmutasi_idbarang_search', $editor, $this->dataset, $lookupDataset, 'id', 'idgol', '');
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for qty field
            //
            $editor = new TextEdit('qty_edit');
            $editColumn = new CustomEditColumn('Qty', 'qty', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for debit field
            //
            $editor = new TextEdit('debit_edit');
            $editColumn = new CustomEditColumn('Debit', 'debit', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for mutasi field
            //
            $editor = new TextEdit('mutasi_edit');
            $editColumn = new CustomEditColumn('Mutasi', 'mutasi', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for retur field
            //
            $editor = new TextEdit('retur_edit');
            $editColumn = new CustomEditColumn('Retur', 'retur', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for terpakai field
            //
            $editor = new TextEdit('terpakai_edit');
            $editColumn = new CustomEditColumn('Terpakai', 'terpakai', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for sisa field
            //
            $editor = new TextEdit('sisa_edit');
            $editColumn = new CustomEditColumn('Sisa', 'sisa', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for pesan field
            //
            $editor = new TextEdit('pesan_edit');
            $editColumn = new CustomEditColumn('Pesan', 'pesan', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for proses field
            //
            $editor = new TextEdit('proses_edit');
            $editColumn = new CustomEditColumn('Proses', 'proses', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for gagal field
            //
            $editor = new TextEdit('gagal_edit');
            $editColumn = new CustomEditColumn('Gagal', 'gagal', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for bahan field
            //
            $editor = new TextEdit('bahan_edit');
            $editColumn = new CustomEditColumn('Bahan', 'bahan', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for diskonnota field
            //
            $editor = new TextEdit('diskonnota_edit');
            $editColumn = new CustomEditColumn('Diskonnota', 'diskonnota', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for hpp field
            //
            $editor = new TextEdit('hpp_edit');
            $editColumn = new CustomEditColumn('Hpp', 'hpp', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for hppbeli field
            //
            $editor = new TextEdit('hppbeli_edit');
            $editColumn = new CustomEditColumn('Hppbeli', 'hppbeli', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for idlokasi field
            //
            $editor = new DynamicCombobox('idlokasi_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lokasi`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('alamat'),
                    new StringField('kota'),
                    new StringField('pimpinan'),
                    new StringField('telp'),
                    new StringField('fax'),
                    new IntegerField('aktif')
                )
            );
            $lookupDataset->setOrderByField('kode', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Idlokasi', 'idlokasi', 'idlokasi_kode', 'multi_edit_brg_trdmutasi_idlokasi_search', $editor, $this->dataset, $lookupDataset, 'id', 'kode', '');
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for idlokasi2 field
            //
            $editor = new DynamicCombobox('idlokasi2_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lokasi`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('alamat'),
                    new StringField('kota'),
                    new StringField('pimpinan'),
                    new StringField('telp'),
                    new StringField('fax'),
                    new IntegerField('aktif')
                )
            );
            $lookupDataset->setOrderByField('kode', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Idlokasi2', 'idlokasi2', 'idlokasi2_kode', 'multi_edit_brg_trdmutasi_idlokasi2_search', $editor, $this->dataset, $lookupDataset, 'id', 'kode', '');
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for cektr field
            //
            $editor = new TextEdit('cektr_edit');
            $editColumn = new CustomEditColumn('Cektr', 'cektr', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for id field
            //
            $editor = new DynamicCombobox('id_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`trd`');
            $lookupDataset->addFields(
                array(
                    new StringField('id', true, true),
                    new StringField('notrans', true),
                    new IntegerField('idtrans', true),
                    new IntegerField('idbarang', true),
                    new StringField('tipe'),
                    new StringField('kode', true),
                    new IntegerField('qtynota'),
                    new IntegerField('idsatuan'),
                    new IntegerField('isi'),
                    new IntegerField('harga'),
                    new IntegerField('jumlah'),
                    new IntegerField('diskon'),
                    new StringField('diskon2'),
                    new IntegerField('biaya'),
                    new IntegerField('total'),
                    new StringField('idx')
                )
            );
            $lookupDataset->setOrderByField('notrans', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id', 'id', 'id_notrans', 'insert_brg_trdmutasi_id_search', $editor, $this->dataset, $lookupDataset, 'id', 'notrans', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for refid field
            //
            $editor = new DynamicCombobox('refid_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`trd`');
            $lookupDataset->addFields(
                array(
                    new StringField('id', true, true),
                    new StringField('notrans', true),
                    new IntegerField('idtrans', true),
                    new IntegerField('idbarang', true),
                    new StringField('tipe'),
                    new StringField('kode', true),
                    new IntegerField('qtynota'),
                    new IntegerField('idsatuan'),
                    new IntegerField('isi'),
                    new IntegerField('harga'),
                    new IntegerField('jumlah'),
                    new IntegerField('diskon'),
                    new StringField('diskon2'),
                    new IntegerField('biaya'),
                    new IntegerField('total'),
                    new StringField('idx')
                )
            );
            $lookupDataset->setOrderByField('notrans', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Refid', 'refid', 'refid_notrans', 'insert_brg_trdmutasi_refid_search', $editor, $this->dataset, $lookupDataset, 'id', 'notrans', '');
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for idbarang field
            //
            $editor = new DynamicCombobox('idbarang_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('idgol', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Idbarang', 'idbarang', 'idbarang_idgol', 'insert_brg_trdmutasi_idbarang_search', $editor, $this->dataset, $lookupDataset, 'id', 'idgol', '');
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for qty field
            //
            $editor = new TextEdit('qty_edit');
            $editColumn = new CustomEditColumn('Qty', 'qty', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for debit field
            //
            $editor = new TextEdit('debit_edit');
            $editColumn = new CustomEditColumn('Debit', 'debit', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for mutasi field
            //
            $editor = new TextEdit('mutasi_edit');
            $editColumn = new CustomEditColumn('Mutasi', 'mutasi', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for retur field
            //
            $editor = new TextEdit('retur_edit');
            $editColumn = new CustomEditColumn('Retur', 'retur', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for terpakai field
            //
            $editor = new TextEdit('terpakai_edit');
            $editColumn = new CustomEditColumn('Terpakai', 'terpakai', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for sisa field
            //
            $editor = new TextEdit('sisa_edit');
            $editColumn = new CustomEditColumn('Sisa', 'sisa', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for pesan field
            //
            $editor = new TextEdit('pesan_edit');
            $editColumn = new CustomEditColumn('Pesan', 'pesan', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for proses field
            //
            $editor = new TextEdit('proses_edit');
            $editColumn = new CustomEditColumn('Proses', 'proses', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for gagal field
            //
            $editor = new TextEdit('gagal_edit');
            $editColumn = new CustomEditColumn('Gagal', 'gagal', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for bahan field
            //
            $editor = new TextEdit('bahan_edit');
            $editColumn = new CustomEditColumn('Bahan', 'bahan', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for diskonnota field
            //
            $editor = new TextEdit('diskonnota_edit');
            $editColumn = new CustomEditColumn('Diskonnota', 'diskonnota', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for hpp field
            //
            $editor = new TextEdit('hpp_edit');
            $editColumn = new CustomEditColumn('Hpp', 'hpp', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for hppbeli field
            //
            $editor = new TextEdit('hppbeli_edit');
            $editColumn = new CustomEditColumn('Hppbeli', 'hppbeli', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for idlokasi field
            //
            $editor = new DynamicCombobox('idlokasi_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lokasi`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('alamat'),
                    new StringField('kota'),
                    new StringField('pimpinan'),
                    new StringField('telp'),
                    new StringField('fax'),
                    new IntegerField('aktif')
                )
            );
            $lookupDataset->setOrderByField('kode', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Idlokasi', 'idlokasi', 'idlokasi_kode', 'insert_brg_trdmutasi_idlokasi_search', $editor, $this->dataset, $lookupDataset, 'id', 'kode', '');
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for idlokasi2 field
            //
            $editor = new DynamicCombobox('idlokasi2_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lokasi`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('alamat'),
                    new StringField('kota'),
                    new StringField('pimpinan'),
                    new StringField('telp'),
                    new StringField('fax'),
                    new IntegerField('aktif')
                )
            );
            $lookupDataset->setOrderByField('kode', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Idlokasi2', 'idlokasi2', 'idlokasi2_kode', 'insert_brg_trdmutasi_idlokasi2_search', $editor, $this->dataset, $lookupDataset, 'id', 'kode', '');
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for cektr field
            //
            $editor = new TextEdit('cektr_edit');
            $editColumn = new CustomEditColumn('Cektr', 'cektr', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            $grid->SetShowAddButton(true && $this->GetSecurityInfo()->HasAddGrant());
        }
    
        private function AddMultiUploadColumn(Grid $grid)
        {
    
        }
    
        protected function AddPrintColumns(Grid $grid)
        {
            //
            // View column for notrans field
            //
            $column = new TextViewColumn('id', 'id_notrans', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for notrans field
            //
            $column = new TextViewColumn('refid', 'refid_notrans', 'Refid', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for idgol field
            //
            $column = new NumberViewColumn('idbarang', 'idbarang_idgol', 'Idbarang', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for qty field
            //
            $column = new NumberViewColumn('qty', 'qty', 'Qty', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddPrintColumn($column);
            
            //
            // View column for debit field
            //
            $column = new NumberViewColumn('debit', 'debit', 'Debit', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for mutasi field
            //
            $column = new NumberViewColumn('mutasi', 'mutasi', 'Mutasi', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddPrintColumn($column);
            
            //
            // View column for retur field
            //
            $column = new NumberViewColumn('retur', 'retur', 'Retur', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddPrintColumn($column);
            
            //
            // View column for terpakai field
            //
            $column = new NumberViewColumn('terpakai', 'terpakai', 'Terpakai', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddPrintColumn($column);
            
            //
            // View column for sisa field
            //
            $column = new NumberViewColumn('sisa', 'sisa', 'Sisa', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddPrintColumn($column);
            
            //
            // View column for pesan field
            //
            $column = new NumberViewColumn('pesan', 'pesan', 'Pesan', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddPrintColumn($column);
            
            //
            // View column for proses field
            //
            $column = new NumberViewColumn('proses', 'proses', 'Proses', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddPrintColumn($column);
            
            //
            // View column for gagal field
            //
            $column = new NumberViewColumn('gagal', 'gagal', 'Gagal', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddPrintColumn($column);
            
            //
            // View column for bahan field
            //
            $column = new NumberViewColumn('bahan', 'bahan', 'Bahan', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddPrintColumn($column);
            
            //
            // View column for diskonnota field
            //
            $column = new NumberViewColumn('diskonnota', 'diskonnota', 'Diskonnota', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddPrintColumn($column);
            
            //
            // View column for hpp field
            //
            $column = new NumberViewColumn('hpp', 'hpp', 'Hpp', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddPrintColumn($column);
            
            //
            // View column for hppbeli field
            //
            $column = new NumberViewColumn('hppbeli', 'hppbeli', 'Hppbeli', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for kode field
            //
            $column = new TextViewColumn('idlokasi', 'idlokasi_kode', 'Idlokasi', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for kode field
            //
            $column = new TextViewColumn('idlokasi2', 'idlokasi2_kode', 'Idlokasi2', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for cektr field
            //
            $column = new NumberViewColumn('cektr', 'cektr', 'Cektr', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for notrans field
            //
            $column = new TextViewColumn('id', 'id_notrans', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for notrans field
            //
            $column = new TextViewColumn('refid', 'refid_notrans', 'Refid', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for idgol field
            //
            $column = new NumberViewColumn('idbarang', 'idbarang_idgol', 'Idbarang', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for qty field
            //
            $column = new NumberViewColumn('qty', 'qty', 'Qty', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddExportColumn($column);
            
            //
            // View column for debit field
            //
            $column = new NumberViewColumn('debit', 'debit', 'Debit', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for mutasi field
            //
            $column = new NumberViewColumn('mutasi', 'mutasi', 'Mutasi', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddExportColumn($column);
            
            //
            // View column for retur field
            //
            $column = new NumberViewColumn('retur', 'retur', 'Retur', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddExportColumn($column);
            
            //
            // View column for terpakai field
            //
            $column = new NumberViewColumn('terpakai', 'terpakai', 'Terpakai', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddExportColumn($column);
            
            //
            // View column for sisa field
            //
            $column = new NumberViewColumn('sisa', 'sisa', 'Sisa', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddExportColumn($column);
            
            //
            // View column for pesan field
            //
            $column = new NumberViewColumn('pesan', 'pesan', 'Pesan', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddExportColumn($column);
            
            //
            // View column for proses field
            //
            $column = new NumberViewColumn('proses', 'proses', 'Proses', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddExportColumn($column);
            
            //
            // View column for gagal field
            //
            $column = new NumberViewColumn('gagal', 'gagal', 'Gagal', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddExportColumn($column);
            
            //
            // View column for bahan field
            //
            $column = new NumberViewColumn('bahan', 'bahan', 'Bahan', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddExportColumn($column);
            
            //
            // View column for diskonnota field
            //
            $column = new NumberViewColumn('diskonnota', 'diskonnota', 'Diskonnota', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddExportColumn($column);
            
            //
            // View column for hpp field
            //
            $column = new NumberViewColumn('hpp', 'hpp', 'Hpp', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddExportColumn($column);
            
            //
            // View column for hppbeli field
            //
            $column = new NumberViewColumn('hppbeli', 'hppbeli', 'Hppbeli', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for kode field
            //
            $column = new TextViewColumn('idlokasi', 'idlokasi_kode', 'Idlokasi', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for kode field
            //
            $column = new TextViewColumn('idlokasi2', 'idlokasi2_kode', 'Idlokasi2', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for cektr field
            //
            $column = new NumberViewColumn('cektr', 'cektr', 'Cektr', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for notrans field
            //
            $column = new TextViewColumn('id', 'id_notrans', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for notrans field
            //
            $column = new TextViewColumn('refid', 'refid_notrans', 'Refid', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for idgol field
            //
            $column = new NumberViewColumn('idbarang', 'idbarang_idgol', 'Idbarang', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for qty field
            //
            $column = new NumberViewColumn('qty', 'qty', 'Qty', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddCompareColumn($column);
            
            //
            // View column for debit field
            //
            $column = new NumberViewColumn('debit', 'debit', 'Debit', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for mutasi field
            //
            $column = new NumberViewColumn('mutasi', 'mutasi', 'Mutasi', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddCompareColumn($column);
            
            //
            // View column for retur field
            //
            $column = new NumberViewColumn('retur', 'retur', 'Retur', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddCompareColumn($column);
            
            //
            // View column for terpakai field
            //
            $column = new NumberViewColumn('terpakai', 'terpakai', 'Terpakai', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddCompareColumn($column);
            
            //
            // View column for sisa field
            //
            $column = new NumberViewColumn('sisa', 'sisa', 'Sisa', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddCompareColumn($column);
            
            //
            // View column for pesan field
            //
            $column = new NumberViewColumn('pesan', 'pesan', 'Pesan', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddCompareColumn($column);
            
            //
            // View column for proses field
            //
            $column = new NumberViewColumn('proses', 'proses', 'Proses', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddCompareColumn($column);
            
            //
            // View column for gagal field
            //
            $column = new NumberViewColumn('gagal', 'gagal', 'Gagal', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddCompareColumn($column);
            
            //
            // View column for bahan field
            //
            $column = new NumberViewColumn('bahan', 'bahan', 'Bahan', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddCompareColumn($column);
            
            //
            // View column for diskonnota field
            //
            $column = new NumberViewColumn('diskonnota', 'diskonnota', 'Diskonnota', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddCompareColumn($column);
            
            //
            // View column for hpp field
            //
            $column = new NumberViewColumn('hpp', 'hpp', 'Hpp', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddCompareColumn($column);
            
            //
            // View column for hppbeli field
            //
            $column = new NumberViewColumn('hppbeli', 'hppbeli', 'Hppbeli', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for kode field
            //
            $column = new TextViewColumn('idlokasi', 'idlokasi_kode', 'Idlokasi', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for kode field
            //
            $column = new TextViewColumn('idlokasi2', 'idlokasi2_kode', 'Idlokasi2', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for cektr field
            //
            $column = new NumberViewColumn('cektr', 'cektr', 'Cektr', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
        }
    
        private function AddCompareHeaderColumns(Grid $grid)
        {
    
        }
    
        public function GetPageDirection()
        {
            return null;
        }
    
        public function isFilterConditionRequired()
        {
            return false;
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetDisplaySetToNullCheckBox(false);
            $column->SetDisplaySetToDefaultCheckBox(false);
    		$column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
        
        public function GetEnableModalGridInsert() { return true; }
        public function GetEnableModalGridEdit() { return true; }
        
        protected function GetEnableModalGridDelete() { return true; }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset);
            if ($this->GetSecurityInfo()->HasDeleteGrant())
               $result->SetAllowDeleteSelected(true);
            else
               $result->SetAllowDeleteSelected(false);   
            
            ApplyCommonPageSettings($this, $result);
            
            $result->SetUseImagesForActions(true);
            $result->SetUseFixedHeader(false);
            $result->SetShowLineNumbers(true);
            $result->SetViewMode(ViewMode::TABLE);
            $result->setEnableRuntimeCustomization(true);
            $result->setAllowCompare(true);
            $this->AddCompareHeaderColumns($result);
            $this->AddCompareColumns($result);
            $result->setMultiEditAllowed($this->GetSecurityInfo()->HasEditGrant() && true);
            $result->setTableBordered(false);
            $result->setTableCondensed(false);
            
            $result->SetHighlightRowAtHover(true);
            $result->SetWidth('');
            $this->AddOperationsColumns($result);
            $this->AddFieldColumns($result);
            $this->AddSingleRecordViewColumns($result);
            $this->AddEditColumns($result);
            $this->AddMultiEditColumns($result);
            $this->AddInsertColumns($result);
            $this->AddPrintColumns($result);
            $this->AddExportColumns($result);
            $this->AddMultiUploadColumn($result);
    
    
            $this->SetShowPageList(true);
            $this->SetShowTopPageNavigator(true);
            $this->SetShowBottomPageNavigator(true);
            $this->setPrintListAvailable(true);
            $this->setPrintListRecordAvailable(false);
            $this->setPrintOneRecordAvailable(true);
            $this->setAllowPrintSelectedRecords(true);
            $this->setExportListAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportSelectedRecordsAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportListRecordAvailable(array());
            $this->setExportOneRecordAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
    
            return $result;
        }
     
        protected function setClientSideEvents(Grid $grid) {
    
        }
    
        protected function doRegisterHandlers() {
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`trd`');
            $lookupDataset->addFields(
                array(
                    new StringField('id', true, true),
                    new StringField('notrans', true),
                    new IntegerField('idtrans', true),
                    new IntegerField('idbarang', true),
                    new StringField('tipe'),
                    new StringField('kode', true),
                    new IntegerField('qtynota'),
                    new IntegerField('idsatuan'),
                    new IntegerField('isi'),
                    new IntegerField('harga'),
                    new IntegerField('jumlah'),
                    new IntegerField('diskon'),
                    new StringField('diskon2'),
                    new IntegerField('biaya'),
                    new IntegerField('total'),
                    new StringField('idx')
                )
            );
            $lookupDataset->setOrderByField('notrans', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_brg_trdmutasi_id_search', 'id', 'notrans', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`trd`');
            $lookupDataset->addFields(
                array(
                    new StringField('id', true, true),
                    new StringField('notrans', true),
                    new IntegerField('idtrans', true),
                    new IntegerField('idbarang', true),
                    new StringField('tipe'),
                    new StringField('kode', true),
                    new IntegerField('qtynota'),
                    new IntegerField('idsatuan'),
                    new IntegerField('isi'),
                    new IntegerField('harga'),
                    new IntegerField('jumlah'),
                    new IntegerField('diskon'),
                    new StringField('diskon2'),
                    new IntegerField('biaya'),
                    new IntegerField('total'),
                    new StringField('idx')
                )
            );
            $lookupDataset->setOrderByField('notrans', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_brg_trdmutasi_refid_search', 'id', 'notrans', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('idgol', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_brg_trdmutasi_idbarang_search', 'id', 'idgol', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lokasi`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('alamat'),
                    new StringField('kota'),
                    new StringField('pimpinan'),
                    new StringField('telp'),
                    new StringField('fax'),
                    new IntegerField('aktif')
                )
            );
            $lookupDataset->setOrderByField('kode', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_brg_trdmutasi_idlokasi_search', 'id', 'kode', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lokasi`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('alamat'),
                    new StringField('kota'),
                    new StringField('pimpinan'),
                    new StringField('telp'),
                    new StringField('fax'),
                    new IntegerField('aktif')
                )
            );
            $lookupDataset->setOrderByField('kode', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_brg_trdmutasi_idlokasi2_search', 'id', 'kode', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`trd`');
            $lookupDataset->addFields(
                array(
                    new StringField('id', true, true),
                    new StringField('notrans', true),
                    new IntegerField('idtrans', true),
                    new IntegerField('idbarang', true),
                    new StringField('tipe'),
                    new StringField('kode', true),
                    new IntegerField('qtynota'),
                    new IntegerField('idsatuan'),
                    new IntegerField('isi'),
                    new IntegerField('harga'),
                    new IntegerField('jumlah'),
                    new IntegerField('diskon'),
                    new StringField('diskon2'),
                    new IntegerField('biaya'),
                    new IntegerField('total'),
                    new StringField('idx')
                )
            );
            $lookupDataset->setOrderByField('notrans', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_brg_trdmutasi_id_search', 'id', 'notrans', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`trd`');
            $lookupDataset->addFields(
                array(
                    new StringField('id', true, true),
                    new StringField('notrans', true),
                    new IntegerField('idtrans', true),
                    new IntegerField('idbarang', true),
                    new StringField('tipe'),
                    new StringField('kode', true),
                    new IntegerField('qtynota'),
                    new IntegerField('idsatuan'),
                    new IntegerField('isi'),
                    new IntegerField('harga'),
                    new IntegerField('jumlah'),
                    new IntegerField('diskon'),
                    new StringField('diskon2'),
                    new IntegerField('biaya'),
                    new IntegerField('total'),
                    new StringField('idx')
                )
            );
            $lookupDataset->setOrderByField('notrans', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_brg_trdmutasi_refid_search', 'id', 'notrans', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('idgol', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_brg_trdmutasi_idbarang_search', 'id', 'idgol', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lokasi`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('alamat'),
                    new StringField('kota'),
                    new StringField('pimpinan'),
                    new StringField('telp'),
                    new StringField('fax'),
                    new IntegerField('aktif')
                )
            );
            $lookupDataset->setOrderByField('kode', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_brg_trdmutasi_idlokasi_search', 'id', 'kode', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lokasi`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('alamat'),
                    new StringField('kota'),
                    new StringField('pimpinan'),
                    new StringField('telp'),
                    new StringField('fax'),
                    new IntegerField('aktif')
                )
            );
            $lookupDataset->setOrderByField('kode', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_brg_trdmutasi_idlokasi2_search', 'id', 'kode', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`trd`');
            $lookupDataset->addFields(
                array(
                    new StringField('id', true, true),
                    new StringField('notrans', true),
                    new IntegerField('idtrans', true),
                    new IntegerField('idbarang', true),
                    new StringField('tipe'),
                    new StringField('kode', true),
                    new IntegerField('qtynota'),
                    new IntegerField('idsatuan'),
                    new IntegerField('isi'),
                    new IntegerField('harga'),
                    new IntegerField('jumlah'),
                    new IntegerField('diskon'),
                    new StringField('diskon2'),
                    new IntegerField('biaya'),
                    new IntegerField('total'),
                    new StringField('idx')
                )
            );
            $lookupDataset->setOrderByField('notrans', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_brg_trdmutasi_id_search', 'id', 'notrans', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`trd`');
            $lookupDataset->addFields(
                array(
                    new StringField('id', true, true),
                    new StringField('notrans', true),
                    new IntegerField('idtrans', true),
                    new IntegerField('idbarang', true),
                    new StringField('tipe'),
                    new StringField('kode', true),
                    new IntegerField('qtynota'),
                    new IntegerField('idsatuan'),
                    new IntegerField('isi'),
                    new IntegerField('harga'),
                    new IntegerField('jumlah'),
                    new IntegerField('diskon'),
                    new StringField('diskon2'),
                    new IntegerField('biaya'),
                    new IntegerField('total'),
                    new StringField('idx')
                )
            );
            $lookupDataset->setOrderByField('notrans', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_brg_trdmutasi_refid_search', 'id', 'notrans', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('idgol', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_brg_trdmutasi_idbarang_search', 'id', 'idgol', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lokasi`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('alamat'),
                    new StringField('kota'),
                    new StringField('pimpinan'),
                    new StringField('telp'),
                    new StringField('fax'),
                    new IntegerField('aktif')
                )
            );
            $lookupDataset->setOrderByField('kode', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_brg_trdmutasi_idlokasi_search', 'id', 'kode', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lokasi`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('alamat'),
                    new StringField('kota'),
                    new StringField('pimpinan'),
                    new StringField('telp'),
                    new StringField('fax'),
                    new IntegerField('aktif')
                )
            );
            $lookupDataset->setOrderByField('kode', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_brg_trdmutasi_idlokasi2_search', 'id', 'kode', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`trd`');
            $lookupDataset->addFields(
                array(
                    new StringField('id', true, true),
                    new StringField('notrans', true),
                    new IntegerField('idtrans', true),
                    new IntegerField('idbarang', true),
                    new StringField('tipe'),
                    new StringField('kode', true),
                    new IntegerField('qtynota'),
                    new IntegerField('idsatuan'),
                    new IntegerField('isi'),
                    new IntegerField('harga'),
                    new IntegerField('jumlah'),
                    new IntegerField('diskon'),
                    new StringField('diskon2'),
                    new IntegerField('biaya'),
                    new IntegerField('total'),
                    new StringField('idx')
                )
            );
            $lookupDataset->setOrderByField('notrans', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_brg_trdmutasi_refid_search', 'id', 'notrans', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $lookupDataset->setOrderByField('idgol', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_brg_trdmutasi_idbarang_search', 'id', 'idgol', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lokasi`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('alamat'),
                    new StringField('kota'),
                    new StringField('pimpinan'),
                    new StringField('telp'),
                    new StringField('fax'),
                    new IntegerField('aktif')
                )
            );
            $lookupDataset->setOrderByField('kode', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_brg_trdmutasi_idlokasi_search', 'id', 'kode', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lokasi`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('alamat'),
                    new StringField('kota'),
                    new StringField('pimpinan'),
                    new StringField('telp'),
                    new StringField('fax'),
                    new IntegerField('aktif')
                )
            );
            $lookupDataset->setOrderByField('kode', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_brg_trdmutasi_idlokasi2_search', 'id', 'kode', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
        }
       
        protected function doCustomRenderColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderPrintColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderExportColumn($exportType, $fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomDrawRow($rowData, &$cellFontColor, &$cellFontSize, &$cellBgColor, &$cellItalicAttr, &$cellBoldAttr)
        {
    
        }
    
        protected function doExtendedCustomDrawRow($rowData, &$rowCellStyles, &$rowStyles, &$rowClasses, &$cellClasses)
        {
    
        }
    
        protected function doCustomRenderTotal($totalValue, $aggregate, $columnName, &$customText, &$handled)
        {
    
        }
    
        protected function doCustomDefaultValues(&$values, &$handled) 
        {
    
        }
    
        protected function doCustomCompareColumn($columnName, $valueA, $valueB, &$result)
        {
    
        }
    
        protected function doBeforeInsertRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doBeforeUpdateRecord($page, $oldRowData, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doBeforeDeleteRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterInsertRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterUpdateRecord($page, $oldRowData, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterDeleteRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doCustomHTMLHeader($page, &$customHtmlHeaderText)
        { 
    
        }
    
        protected function doGetCustomTemplate($type, $part, $mode, &$result, &$params)
        {
    
        }
    
        protected function doGetCustomExportOptions(Page $page, $exportType, $rowData, &$options)
        {
    
        }
    
        protected function doFileUpload($fieldName, $rowData, &$result, &$accept, $originalFileName, $originalFileExtension, $fileSize, $tempFileName)
        {
    
        }
    
        protected function doPrepareChart(Chart $chart)
        {
    
        }
    
        protected function doPrepareColumnFilter(ColumnFilter $columnFilter)
        {
    
        }
    
        protected function doPrepareFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
    
        }
    
        protected function doGetSelectionFilters(FixedKeysArray $columns, &$result)
        {
    
        }
    
        protected function doGetCustomFormLayout($mode, FixedKeysArray $columns, FormLayout $layout)
        {
    
        }
    
        protected function doGetCustomColumnGroup(FixedKeysArray $columns, ViewColumnGroup $columnGroup)
        {
    
        }
    
        protected function doPageLoaded()
        {
    
        }
    
        protected function doCalculateFields($rowData, $fieldName, &$value)
        {
    
        }
    
        protected function doGetCustomRecordPermissions(Page $page, &$usingCondition, $rowData, &$allowEdit, &$allowDelete, &$mergeWithDefault, &$handled)
        {
    
        }
    
        protected function doAddEnvironmentVariables(Page $page, &$variables)
        {
    
        }
    
    }
    
    // OnBeforePageExecute event handler
    
    
    
    class brgPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Brg');
            $this->SetMenuLabel('Brg');
            $this->SetHeader(GetPagesHeader());
            $this->SetFooter(GetPagesFooter());
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brg`');
            $this->dataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('idgol', true),
                    new StringField('kode', true),
                    new StringField('nama'),
                    new StringField('merk'),
                    new StringField('golongan'),
                    new StringField('kelompok'),
                    new StringField('jenis'),
                    new IntegerField('aktif'),
                    new IntegerField('defsatuan'),
                    new IntegerField('defgalery')
                )
            );
            $this->dataset->AddLookupField('idgol', 'brggolongan', new IntegerField('id'), new StringField('nama', false, false, false, false, 'idgol_nama', 'idgol_nama_brggolongan'), 'idgol_nama_brggolongan');
            $this->dataset->AddLookupField('defgalery', 'brggaleri', new IntegerField('id'), new IntegerField('idbarang', false, false, false, false, 'defgalery_idbarang', 'defgalery_idbarang_brggaleri'), 'defgalery_idbarang_brggaleri');
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function CreatePageNavigator()
        {
            $result = new CompositePageNavigator($this);
            
            $partitionNavigator = new PageNavigator('pnav', $this, $this->dataset);
            $partitionNavigator->SetRowsPerPage(20);
            $result->AddPageNavigator($partitionNavigator);
            
            return $result;
        }
    
        protected function CreateRssGenerator()
        {
            return null;
        }
    
        protected function setupCharts()
        {
    
        }
    
        protected function getFiltersColumns()
        {
            return array(
                new FilterColumn($this->dataset, 'id', 'id', 'Id'),
                new FilterColumn($this->dataset, 'idgol', 'idgol_nama', 'Idgol'),
                new FilterColumn($this->dataset, 'kode', 'kode', 'Kode'),
                new FilterColumn($this->dataset, 'nama', 'nama', 'Nama'),
                new FilterColumn($this->dataset, 'merk', 'merk', 'Merk'),
                new FilterColumn($this->dataset, 'golongan', 'golongan', 'Golongan'),
                new FilterColumn($this->dataset, 'kelompok', 'kelompok', 'Kelompok'),
                new FilterColumn($this->dataset, 'jenis', 'jenis', 'Jenis'),
                new FilterColumn($this->dataset, 'aktif', 'aktif', 'Aktif'),
                new FilterColumn($this->dataset, 'defsatuan', 'defsatuan', 'Defsatuan'),
                new FilterColumn($this->dataset, 'defgalery', 'defgalery_idbarang', 'Defgalery')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['id'])
                ->addColumn($columns['idgol'])
                ->addColumn($columns['kode'])
                ->addColumn($columns['nama'])
                ->addColumn($columns['merk'])
                ->addColumn($columns['golongan'])
                ->addColumn($columns['kelompok'])
                ->addColumn($columns['jenis'])
                ->addColumn($columns['aktif'])
                ->addColumn($columns['defsatuan'])
                ->addColumn($columns['defgalery']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('idgol')
                ->setOptionsFor('defgalery');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new TextEdit('id_edit');
            
            $filterBuilder->addColumn(
                $columns['id'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('idgol_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_brg_idgol_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('idgol', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_brg_idgol_search');
            
            $text_editor = new TextEdit('idgol');
            
            $filterBuilder->addColumn(
                $columns['idgol'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('kode_edit');
            $main_editor->SetMaxLength(20);
            
            $filterBuilder->addColumn(
                $columns['kode'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('nama_edit');
            $main_editor->SetMaxLength(50);
            
            $filterBuilder->addColumn(
                $columns['nama'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('merk_edit');
            $main_editor->SetMaxLength(15);
            
            $filterBuilder->addColumn(
                $columns['merk'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('golongan_edit');
            $main_editor->SetMaxLength(20);
            
            $filterBuilder->addColumn(
                $columns['golongan'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('kelompok_edit');
            $main_editor->SetMaxLength(15);
            
            $filterBuilder->addColumn(
                $columns['kelompok'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('jenis_edit');
            $main_editor->SetMaxLength(15);
            
            $filterBuilder->addColumn(
                $columns['jenis'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('aktif_edit');
            
            $filterBuilder->addColumn(
                $columns['aktif'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('defsatuan_edit');
            
            $filterBuilder->addColumn(
                $columns['defsatuan'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('defgalery_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_brg_defgalery_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('defgalery', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_brg_defgalery_search');
            
            $filterBuilder->addColumn(
                $columns['defgalery'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
        }
    
        protected function AddOperationsColumns(Grid $grid)
        {
            $actions = $grid->getActions();
            $actions->setCaption($this->GetLocalizerCaptions()->GetMessageString('Actions'));
            $actions->setPosition(ActionList::POSITION_LEFT);
            
            if ($this->GetSecurityInfo()->HasViewGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('View'), OPERATION_VIEW, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
            
            if ($this->GetSecurityInfo()->HasEditGrant())
            {
                $operation = new AjaxOperation(OPERATION_EDIT,
                    $this->GetLocalizerCaptions()->GetMessageString('Edit'),
                    $this->GetLocalizerCaptions()->GetMessageString('Edit'), $this->dataset,
                    $this->GetGridEditHandler(), $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowEditButtonHandler', $this);
            }
            
            if ($this->GetSecurityInfo()->HasDeleteGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Delete'), OPERATION_DELETE, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowDeleteButtonHandler', $this);
                $operation->SetAdditionalAttribute('data-modal-operation', 'delete');
                $operation->SetAdditionalAttribute('data-delete-handler-name', $this->GetModalGridDeleteHandler());
            }
            
            if ($this->GetSecurityInfo()->HasAddGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Copy'), OPERATION_COPY, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
        }
    
        protected function AddFieldColumns(Grid $grid, $withDetails = true)
        {
            if (GetCurrentUserPermissionsForPage('brg.brggaleri')->HasViewGrant() && $withDetails)
            {
            //
            // View column for brg_brggaleri detail
            //
            $column = new DetailColumn(array('id'), 'brg.brggaleri', 'brg_brggaleri_handler', $this->dataset, 'Brggaleri');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            }
            
            if (GetCurrentUserPermissionsForPage('brg.brginfo')->HasViewGrant() && $withDetails)
            {
            //
            // View column for brg_brginfo detail
            //
            $column = new DetailColumn(array('id'), 'brg.brginfo', 'brg_brginfo_handler', $this->dataset, 'Brginfo');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            }
            
            if (GetCurrentUserPermissionsForPage('brg.brgsatuan')->HasViewGrant() && $withDetails)
            {
            //
            // View column for brg_brgsatuan detail
            //
            $column = new DetailColumn(array('id'), 'brg.brgsatuan', 'brg_brgsatuan_handler', $this->dataset, 'Brgsatuan');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            }
            
            if (GetCurrentUserPermissionsForPage('brg.fifo')->HasViewGrant() && $withDetails)
            {
            //
            // View column for brg_fifo detail
            //
            $column = new DetailColumn(array('id'), 'brg.fifo', 'brg_fifo_handler', $this->dataset, 'Fifo');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            }
            
            if (GetCurrentUserPermissionsForPage('brg.stok')->HasViewGrant() && $withDetails)
            {
            //
            // View column for brg_stok detail
            //
            $column = new DetailColumn(array('id'), 'brg.stok', 'brg_stok_handler', $this->dataset, 'Stok');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            }
            
            if (GetCurrentUserPermissionsForPage('brg.trd')->HasViewGrant() && $withDetails)
            {
            //
            // View column for brg_trd detail
            //
            $column = new DetailColumn(array('id'), 'brg.trd', 'brg_trd_handler', $this->dataset, 'Trd');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            }
            
            if (GetCurrentUserPermissionsForPage('brg.trd01')->HasViewGrant() && $withDetails)
            {
            //
            // View column for brg_trd01 detail
            //
            $column = new DetailColumn(array('kode'), 'brg.trd01', 'brg_trd01_handler', $this->dataset, 'Trd');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            }
            
            if (GetCurrentUserPermissionsForPage('brg.trdmutasi')->HasViewGrant() && $withDetails)
            {
            //
            // View column for brg_trdmutasi detail
            //
            $column = new DetailColumn(array('id'), 'brg.trdmutasi', 'brg_trdmutasi_handler', $this->dataset, 'Trdmutasi');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            }
            
            //
            // View column for id field
            //
            $column = new NumberViewColumn('id', 'id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for nama field
            //
            $column = new TextViewColumn('idgol', 'idgol_nama', 'Idgol', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for kode field
            //
            $column = new TextViewColumn('kode', 'kode', 'Kode', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for nama field
            //
            $column = new TextViewColumn('nama', 'nama', 'Nama', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for merk field
            //
            $column = new TextViewColumn('merk', 'merk', 'Merk', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for golongan field
            //
            $column = new TextViewColumn('golongan', 'golongan', 'Golongan', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for kelompok field
            //
            $column = new TextViewColumn('kelompok', 'kelompok', 'Kelompok', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for jenis field
            //
            $column = new TextViewColumn('jenis', 'jenis', 'Jenis', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for aktif field
            //
            $column = new NumberViewColumn('aktif', 'aktif', 'Aktif', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for defsatuan field
            //
            $column = new NumberViewColumn('defsatuan', 'defsatuan', 'Defsatuan', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for idbarang field
            //
            $column = new NumberViewColumn('defgalery', 'defgalery_idbarang', 'Defgalery', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for id field
            //
            $column = new NumberViewColumn('id', 'id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for nama field
            //
            $column = new TextViewColumn('idgol', 'idgol_nama', 'Idgol', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for kode field
            //
            $column = new TextViewColumn('kode', 'kode', 'Kode', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for nama field
            //
            $column = new TextViewColumn('nama', 'nama', 'Nama', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for merk field
            //
            $column = new TextViewColumn('merk', 'merk', 'Merk', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for golongan field
            //
            $column = new TextViewColumn('golongan', 'golongan', 'Golongan', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for kelompok field
            //
            $column = new TextViewColumn('kelompok', 'kelompok', 'Kelompok', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for jenis field
            //
            $column = new TextViewColumn('jenis', 'jenis', 'Jenis', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for aktif field
            //
            $column = new NumberViewColumn('aktif', 'aktif', 'Aktif', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for defsatuan field
            //
            $column = new NumberViewColumn('defsatuan', 'defsatuan', 'Defsatuan', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for idbarang field
            //
            $column = new NumberViewColumn('defgalery', 'defgalery_idbarang', 'Defgalery', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for id field
            //
            $editor = new TextEdit('id_edit');
            $editColumn = new CustomEditColumn('Id', 'id', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for idgol field
            //
            $editor = new DynamicCombobox('idgol_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brggolongan`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('nama'),
                    new IntegerField('rek'),
                    new IntegerField('rekjual'),
                    new IntegerField('rekhpp'),
                    new IntegerField('rekopname'),
                    new IntegerField('rekrusak'),
                    new IntegerField('rekpakai')
                )
            );
            $lookupDataset->setOrderByField('nama', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Idgol', 'idgol', 'idgol_nama', 'edit_brg_idgol_search', $editor, $this->dataset, $lookupDataset, 'id', 'nama', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for kode field
            //
            $editor = new TextEdit('kode_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Kode', 'kode', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for nama field
            //
            $editor = new TextEdit('nama_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Nama', 'nama', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for merk field
            //
            $editor = new TextEdit('merk_edit');
            $editor->SetMaxLength(15);
            $editColumn = new CustomEditColumn('Merk', 'merk', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for golongan field
            //
            $editor = new TextEdit('golongan_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Golongan', 'golongan', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for kelompok field
            //
            $editor = new TextEdit('kelompok_edit');
            $editor->SetMaxLength(15);
            $editColumn = new CustomEditColumn('Kelompok', 'kelompok', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for jenis field
            //
            $editor = new TextEdit('jenis_edit');
            $editor->SetMaxLength(15);
            $editColumn = new CustomEditColumn('Jenis', 'jenis', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for aktif field
            //
            $editor = new TextEdit('aktif_edit');
            $editColumn = new CustomEditColumn('Aktif', 'aktif', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for defsatuan field
            //
            $editor = new TextEdit('defsatuan_edit');
            $editColumn = new CustomEditColumn('Defsatuan', 'defsatuan', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for defgalery field
            //
            $editor = new DynamicCombobox('defgalery_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brggaleri`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new IntegerField('idbarang', true),
                    new StringField('namafile'),
                    new DateTimeField('tanggal'),
                    new StringField('tipefile'),
                    new IntegerField('sizefile'),
                    new BlobField('filex')
                )
            );
            $lookupDataset->setOrderByField('idbarang', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Defgalery', 'defgalery', 'defgalery_idbarang', 'edit_brg_defgalery_search', $editor, $this->dataset, $lookupDataset, 'id', 'idbarang', '');
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for idgol field
            //
            $editor = new DynamicCombobox('idgol_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brggolongan`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('nama'),
                    new IntegerField('rek'),
                    new IntegerField('rekjual'),
                    new IntegerField('rekhpp'),
                    new IntegerField('rekopname'),
                    new IntegerField('rekrusak'),
                    new IntegerField('rekpakai')
                )
            );
            $lookupDataset->setOrderByField('nama', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Idgol', 'idgol', 'idgol_nama', 'multi_edit_brg_idgol_search', $editor, $this->dataset, $lookupDataset, 'id', 'nama', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for nama field
            //
            $editor = new TextEdit('nama_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Nama', 'nama', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for merk field
            //
            $editor = new TextEdit('merk_edit');
            $editor->SetMaxLength(15);
            $editColumn = new CustomEditColumn('Merk', 'merk', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for golongan field
            //
            $editor = new TextEdit('golongan_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Golongan', 'golongan', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for kelompok field
            //
            $editor = new TextEdit('kelompok_edit');
            $editor->SetMaxLength(15);
            $editColumn = new CustomEditColumn('Kelompok', 'kelompok', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for jenis field
            //
            $editor = new TextEdit('jenis_edit');
            $editor->SetMaxLength(15);
            $editColumn = new CustomEditColumn('Jenis', 'jenis', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for aktif field
            //
            $editor = new TextEdit('aktif_edit');
            $editColumn = new CustomEditColumn('Aktif', 'aktif', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for defsatuan field
            //
            $editor = new TextEdit('defsatuan_edit');
            $editColumn = new CustomEditColumn('Defsatuan', 'defsatuan', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for defgalery field
            //
            $editor = new DynamicCombobox('defgalery_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brggaleri`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new IntegerField('idbarang', true),
                    new StringField('namafile'),
                    new DateTimeField('tanggal'),
                    new StringField('tipefile'),
                    new IntegerField('sizefile'),
                    new BlobField('filex')
                )
            );
            $lookupDataset->setOrderByField('idbarang', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Defgalery', 'defgalery', 'defgalery_idbarang', 'multi_edit_brg_defgalery_search', $editor, $this->dataset, $lookupDataset, 'id', 'idbarang', '');
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for id field
            //
            $editor = new TextEdit('id_edit');
            $editColumn = new CustomEditColumn('Id', 'id', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for idgol field
            //
            $editor = new DynamicCombobox('idgol_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brggolongan`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('nama'),
                    new IntegerField('rek'),
                    new IntegerField('rekjual'),
                    new IntegerField('rekhpp'),
                    new IntegerField('rekopname'),
                    new IntegerField('rekrusak'),
                    new IntegerField('rekpakai')
                )
            );
            $lookupDataset->setOrderByField('nama', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Idgol', 'idgol', 'idgol_nama', 'insert_brg_idgol_search', $editor, $this->dataset, $lookupDataset, 'id', 'nama', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for kode field
            //
            $editor = new TextEdit('kode_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Kode', 'kode', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for nama field
            //
            $editor = new TextEdit('nama_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Nama', 'nama', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for merk field
            //
            $editor = new TextEdit('merk_edit');
            $editor->SetMaxLength(15);
            $editColumn = new CustomEditColumn('Merk', 'merk', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for golongan field
            //
            $editor = new TextEdit('golongan_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Golongan', 'golongan', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for kelompok field
            //
            $editor = new TextEdit('kelompok_edit');
            $editor->SetMaxLength(15);
            $editColumn = new CustomEditColumn('Kelompok', 'kelompok', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for jenis field
            //
            $editor = new TextEdit('jenis_edit');
            $editor->SetMaxLength(15);
            $editColumn = new CustomEditColumn('Jenis', 'jenis', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for aktif field
            //
            $editor = new TextEdit('aktif_edit');
            $editColumn = new CustomEditColumn('Aktif', 'aktif', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for defsatuan field
            //
            $editor = new TextEdit('defsatuan_edit');
            $editColumn = new CustomEditColumn('Defsatuan', 'defsatuan', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for defgalery field
            //
            $editor = new DynamicCombobox('defgalery_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brggaleri`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new IntegerField('idbarang', true),
                    new StringField('namafile'),
                    new DateTimeField('tanggal'),
                    new StringField('tipefile'),
                    new IntegerField('sizefile'),
                    new BlobField('filex')
                )
            );
            $lookupDataset->setOrderByField('idbarang', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Defgalery', 'defgalery', 'defgalery_idbarang', 'insert_brg_defgalery_search', $editor, $this->dataset, $lookupDataset, 'id', 'idbarang', '');
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            $grid->SetShowAddButton(true && $this->GetSecurityInfo()->HasAddGrant());
        }
    
        private function AddMultiUploadColumn(Grid $grid)
        {
    
        }
    
        protected function AddPrintColumns(Grid $grid)
        {
            //
            // View column for id field
            //
            $column = new NumberViewColumn('id', 'id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for nama field
            //
            $column = new TextViewColumn('idgol', 'idgol_nama', 'Idgol', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for kode field
            //
            $column = new TextViewColumn('kode', 'kode', 'Kode', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for nama field
            //
            $column = new TextViewColumn('nama', 'nama', 'Nama', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for merk field
            //
            $column = new TextViewColumn('merk', 'merk', 'Merk', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for golongan field
            //
            $column = new TextViewColumn('golongan', 'golongan', 'Golongan', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for kelompok field
            //
            $column = new TextViewColumn('kelompok', 'kelompok', 'Kelompok', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for jenis field
            //
            $column = new TextViewColumn('jenis', 'jenis', 'Jenis', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for aktif field
            //
            $column = new NumberViewColumn('aktif', 'aktif', 'Aktif', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for defsatuan field
            //
            $column = new NumberViewColumn('defsatuan', 'defsatuan', 'Defsatuan', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for idbarang field
            //
            $column = new NumberViewColumn('defgalery', 'defgalery_idbarang', 'Defgalery', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for id field
            //
            $column = new NumberViewColumn('id', 'id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for nama field
            //
            $column = new TextViewColumn('idgol', 'idgol_nama', 'Idgol', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for kode field
            //
            $column = new TextViewColumn('kode', 'kode', 'Kode', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for nama field
            //
            $column = new TextViewColumn('nama', 'nama', 'Nama', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for merk field
            //
            $column = new TextViewColumn('merk', 'merk', 'Merk', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for golongan field
            //
            $column = new TextViewColumn('golongan', 'golongan', 'Golongan', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for kelompok field
            //
            $column = new TextViewColumn('kelompok', 'kelompok', 'Kelompok', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for jenis field
            //
            $column = new TextViewColumn('jenis', 'jenis', 'Jenis', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for aktif field
            //
            $column = new NumberViewColumn('aktif', 'aktif', 'Aktif', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for defsatuan field
            //
            $column = new NumberViewColumn('defsatuan', 'defsatuan', 'Defsatuan', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for idbarang field
            //
            $column = new NumberViewColumn('defgalery', 'defgalery_idbarang', 'Defgalery', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for id field
            //
            $column = new NumberViewColumn('id', 'id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for nama field
            //
            $column = new TextViewColumn('idgol', 'idgol_nama', 'Idgol', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for kode field
            //
            $column = new TextViewColumn('kode', 'kode', 'Kode', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for nama field
            //
            $column = new TextViewColumn('nama', 'nama', 'Nama', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for merk field
            //
            $column = new TextViewColumn('merk', 'merk', 'Merk', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for golongan field
            //
            $column = new TextViewColumn('golongan', 'golongan', 'Golongan', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for kelompok field
            //
            $column = new TextViewColumn('kelompok', 'kelompok', 'Kelompok', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for jenis field
            //
            $column = new TextViewColumn('jenis', 'jenis', 'Jenis', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for aktif field
            //
            $column = new NumberViewColumn('aktif', 'aktif', 'Aktif', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for defsatuan field
            //
            $column = new NumberViewColumn('defsatuan', 'defsatuan', 'Defsatuan', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for idbarang field
            //
            $column = new NumberViewColumn('defgalery', 'defgalery_idbarang', 'Defgalery', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
        }
    
        private function AddCompareHeaderColumns(Grid $grid)
        {
    
        }
    
        public function GetPageDirection()
        {
            return null;
        }
    
        public function isFilterConditionRequired()
        {
            return false;
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetDisplaySetToNullCheckBox(false);
            $column->SetDisplaySetToDefaultCheckBox(false);
    		$column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
        function CreateMasterDetailRecordGrid()
        {
            $result = new Grid($this, $this->dataset);
            
            $this->AddFieldColumns($result, false);
            $this->AddPrintColumns($result);
            $this->AddExportColumns($result);
            
            $result->SetAllowDeleteSelected(false);
            $result->SetShowUpdateLink(false);
            $result->SetShowKeyColumnsImagesInHeader(false);
            $result->SetViewMode(ViewMode::TABLE);
            $result->setEnableRuntimeCustomization(false);
            $result->setTableBordered(false);
            $result->setTableCondensed(false);
            
            $this->setupGridColumnGroup($result);
            $this->attachGridEventHandlers($result);
            
            return $result;
        }
        
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
        
        public function GetEnableModalGridInsert() { return true; }
        public function GetEnableModalGridEdit() { return true; }
        
        protected function GetEnableModalGridDelete() { return true; }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset);
            if ($this->GetSecurityInfo()->HasDeleteGrant())
               $result->SetAllowDeleteSelected(true);
            else
               $result->SetAllowDeleteSelected(false);   
            
            ApplyCommonPageSettings($this, $result);
            
            $result->SetUseImagesForActions(true);
            $result->SetUseFixedHeader(false);
            $result->SetShowLineNumbers(true);
            $result->SetViewMode(ViewMode::TABLE);
            $result->setEnableRuntimeCustomization(true);
            $result->setAllowCompare(true);
            $this->AddCompareHeaderColumns($result);
            $this->AddCompareColumns($result);
            $result->setMultiEditAllowed($this->GetSecurityInfo()->HasEditGrant() && true);
            $result->setTableBordered(false);
            $result->setTableCondensed(false);
            
            $result->SetHighlightRowAtHover(true);
            $result->SetWidth('');
            $this->AddOperationsColumns($result);
            $this->AddFieldColumns($result);
            $this->AddSingleRecordViewColumns($result);
            $this->AddEditColumns($result);
            $this->AddMultiEditColumns($result);
            $this->AddInsertColumns($result);
            $this->AddPrintColumns($result);
            $this->AddExportColumns($result);
            $this->AddMultiUploadColumn($result);
    
    
            $this->SetShowPageList(true);
            $this->SetShowTopPageNavigator(true);
            $this->SetShowBottomPageNavigator(true);
            $this->setPrintListAvailable(true);
            $this->setPrintListRecordAvailable(false);
            $this->setPrintOneRecordAvailable(true);
            $this->setAllowPrintSelectedRecords(true);
            $this->setExportListAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportSelectedRecordsAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportListRecordAvailable(array());
            $this->setExportOneRecordAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
    
            return $result;
        }
     
        protected function setClientSideEvents(Grid $grid) {
    
        }
    
        protected function doRegisterHandlers() {
            $detailPage = new brg_brggaleriPage('brg_brggaleri', $this, array('idbarang'), array('id'), $this->GetForeignKeyFields(), $this->CreateMasterDetailRecordGrid(), $this->dataset, GetCurrentUserPermissionsForPage('brg.brggaleri'), 'UTF-8');
            $detailPage->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('brg.brggaleri'));
            $detailPage->SetHttpHandlerName('brg_brggaleri_handler');
            $handler = new PageHTTPHandler('brg_brggaleri_handler', $detailPage);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $detailPage = new brg_brginfoPage('brg_brginfo', $this, array('id'), array('id'), $this->GetForeignKeyFields(), $this->CreateMasterDetailRecordGrid(), $this->dataset, GetCurrentUserPermissionsForPage('brg.brginfo'), 'UTF-8');
            $detailPage->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('brg.brginfo'));
            $detailPage->SetHttpHandlerName('brg_brginfo_handler');
            $handler = new PageHTTPHandler('brg_brginfo_handler', $detailPage);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $detailPage = new brg_brgsatuanPage('brg_brgsatuan', $this, array('id'), array('id'), $this->GetForeignKeyFields(), $this->CreateMasterDetailRecordGrid(), $this->dataset, GetCurrentUserPermissionsForPage('brg.brgsatuan'), 'UTF-8');
            $detailPage->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('brg.brgsatuan'));
            $detailPage->SetHttpHandlerName('brg_brgsatuan_handler');
            $handler = new PageHTTPHandler('brg_brgsatuan_handler', $detailPage);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $detailPage = new brg_fifoPage('brg_fifo', $this, array('idbarang'), array('id'), $this->GetForeignKeyFields(), $this->CreateMasterDetailRecordGrid(), $this->dataset, GetCurrentUserPermissionsForPage('brg.fifo'), 'UTF-8');
            $detailPage->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('brg.fifo'));
            $detailPage->SetHttpHandlerName('brg_fifo_handler');
            $handler = new PageHTTPHandler('brg_fifo_handler', $detailPage);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $detailPage = new brg_stokPage('brg_stok', $this, array('idbarang'), array('id'), $this->GetForeignKeyFields(), $this->CreateMasterDetailRecordGrid(), $this->dataset, GetCurrentUserPermissionsForPage('brg.stok'), 'UTF-8');
            $detailPage->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('brg.stok'));
            $detailPage->SetHttpHandlerName('brg_stok_handler');
            $handler = new PageHTTPHandler('brg_stok_handler', $detailPage);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $detailPage = new brg_trdPage('brg_trd', $this, array('idbarang'), array('id'), $this->GetForeignKeyFields(), $this->CreateMasterDetailRecordGrid(), $this->dataset, GetCurrentUserPermissionsForPage('brg.trd'), 'UTF-8');
            $detailPage->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('brg.trd'));
            $detailPage->SetHttpHandlerName('brg_trd_handler');
            $handler = new PageHTTPHandler('brg_trd_handler', $detailPage);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $detailPage = new brg_trd01Page('brg_trd01', $this, array('kode'), array('kode'), $this->GetForeignKeyFields(), $this->CreateMasterDetailRecordGrid(), $this->dataset, GetCurrentUserPermissionsForPage('brg.trd01'), 'UTF-8');
            $detailPage->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('brg.trd01'));
            $detailPage->SetHttpHandlerName('brg_trd01_handler');
            $handler = new PageHTTPHandler('brg_trd01_handler', $detailPage);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $detailPage = new brg_trdmutasiPage('brg_trdmutasi', $this, array('idbarang'), array('id'), $this->GetForeignKeyFields(), $this->CreateMasterDetailRecordGrid(), $this->dataset, GetCurrentUserPermissionsForPage('brg.trdmutasi'), 'UTF-8');
            $detailPage->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('brg.trdmutasi'));
            $detailPage->SetHttpHandlerName('brg_trdmutasi_handler');
            $handler = new PageHTTPHandler('brg_trdmutasi_handler', $detailPage);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brggolongan`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('nama'),
                    new IntegerField('rek'),
                    new IntegerField('rekjual'),
                    new IntegerField('rekhpp'),
                    new IntegerField('rekopname'),
                    new IntegerField('rekrusak'),
                    new IntegerField('rekpakai')
                )
            );
            $lookupDataset->setOrderByField('nama', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_brg_idgol_search', 'id', 'nama', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brggaleri`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new IntegerField('idbarang', true),
                    new StringField('namafile'),
                    new DateTimeField('tanggal'),
                    new StringField('tipefile'),
                    new IntegerField('sizefile'),
                    new BlobField('filex')
                )
            );
            $lookupDataset->setOrderByField('idbarang', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_brg_defgalery_search', 'id', 'idbarang', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brggolongan`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('nama'),
                    new IntegerField('rek'),
                    new IntegerField('rekjual'),
                    new IntegerField('rekhpp'),
                    new IntegerField('rekopname'),
                    new IntegerField('rekrusak'),
                    new IntegerField('rekpakai')
                )
            );
            $lookupDataset->setOrderByField('nama', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_brg_idgol_search', 'id', 'nama', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brggaleri`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new IntegerField('idbarang', true),
                    new StringField('namafile'),
                    new DateTimeField('tanggal'),
                    new StringField('tipefile'),
                    new IntegerField('sizefile'),
                    new BlobField('filex')
                )
            );
            $lookupDataset->setOrderByField('idbarang', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_brg_defgalery_search', 'id', 'idbarang', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brggolongan`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('nama'),
                    new IntegerField('rek'),
                    new IntegerField('rekjual'),
                    new IntegerField('rekhpp'),
                    new IntegerField('rekopname'),
                    new IntegerField('rekrusak'),
                    new IntegerField('rekpakai')
                )
            );
            $lookupDataset->setOrderByField('nama', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_brg_idgol_search', 'id', 'nama', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brggaleri`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new IntegerField('idbarang', true),
                    new StringField('namafile'),
                    new DateTimeField('tanggal'),
                    new StringField('tipefile'),
                    new IntegerField('sizefile'),
                    new BlobField('filex')
                )
            );
            $lookupDataset->setOrderByField('idbarang', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_brg_defgalery_search', 'id', 'idbarang', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brggolongan`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('nama'),
                    new IntegerField('rek'),
                    new IntegerField('rekjual'),
                    new IntegerField('rekhpp'),
                    new IntegerField('rekopname'),
                    new IntegerField('rekrusak'),
                    new IntegerField('rekpakai')
                )
            );
            $lookupDataset->setOrderByField('nama', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_brg_idgol_search', 'id', 'nama', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brggaleri`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new IntegerField('idbarang', true),
                    new StringField('namafile'),
                    new DateTimeField('tanggal'),
                    new StringField('tipefile'),
                    new IntegerField('sizefile'),
                    new BlobField('filex')
                )
            );
            $lookupDataset->setOrderByField('idbarang', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_brg_defgalery_search', 'id', 'idbarang', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
        }
       
        protected function doCustomRenderColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderPrintColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderExportColumn($exportType, $fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomDrawRow($rowData, &$cellFontColor, &$cellFontSize, &$cellBgColor, &$cellItalicAttr, &$cellBoldAttr)
        {
    
        }
    
        protected function doExtendedCustomDrawRow($rowData, &$rowCellStyles, &$rowStyles, &$rowClasses, &$cellClasses)
        {
    
        }
    
        protected function doCustomRenderTotal($totalValue, $aggregate, $columnName, &$customText, &$handled)
        {
    
        }
    
        protected function doCustomDefaultValues(&$values, &$handled) 
        {
    
        }
    
        protected function doCustomCompareColumn($columnName, $valueA, $valueB, &$result)
        {
    
        }
    
        protected function doBeforeInsertRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doBeforeUpdateRecord($page, $oldRowData, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doBeforeDeleteRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterInsertRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterUpdateRecord($page, $oldRowData, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterDeleteRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doCustomHTMLHeader($page, &$customHtmlHeaderText)
        { 
    
        }
    
        protected function doGetCustomTemplate($type, $part, $mode, &$result, &$params)
        {
    
        }
    
        protected function doGetCustomExportOptions(Page $page, $exportType, $rowData, &$options)
        {
    
        }
    
        protected function doFileUpload($fieldName, $rowData, &$result, &$accept, $originalFileName, $originalFileExtension, $fileSize, $tempFileName)
        {
    
        }
    
        protected function doPrepareChart(Chart $chart)
        {
    
        }
    
        protected function doPrepareColumnFilter(ColumnFilter $columnFilter)
        {
    
        }
    
        protected function doPrepareFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
    
        }
    
        protected function doGetSelectionFilters(FixedKeysArray $columns, &$result)
        {
    
        }
    
        protected function doGetCustomFormLayout($mode, FixedKeysArray $columns, FormLayout $layout)
        {
    
        }
    
        protected function doGetCustomColumnGroup(FixedKeysArray $columns, ViewColumnGroup $columnGroup)
        {
    
        }
    
        protected function doPageLoaded()
        {
    
        }
    
        protected function doCalculateFields($rowData, $fieldName, &$value)
        {
    
        }
    
        protected function doGetCustomRecordPermissions(Page $page, &$usingCondition, $rowData, &$allowEdit, &$allowDelete, &$mergeWithDefault, &$handled)
        {
    
        }
    
        protected function doAddEnvironmentVariables(Page $page, &$variables)
        {
    
        }
    
    }

    SetUpUserAuthorization();

    try
    {
        $Page = new brgPage("brg", "brg.php", GetCurrentUserPermissionsForPage("brg"), 'UTF-8');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("brg"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
