<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NonspmbResource\Pages;
use App\Filament\Resources\NonspmbResource\RelationManagers;
use App\Models\Nonspmb;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class NonspmbResource extends Resource
{
    protected static ?string $model = Nonspmb::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $navigationLabel = 'Data PD Non SPMB';

    public static function getNavigationSort(): ?int
    {
        return 2; // angka lebih kecil muncul lebih dulu
    }
    public static function form(Form $form): Form
   {
        return $form
            ->schema([
                  Card::make()->schema([
                    Fieldset::make('Keperluan Tarik Data')->schema([
                        TextInput::make('asal_sekolah')->label('Asal Sekolah')->default('SMPN '),
                        TextInput::make('tahun_lulus')->label('Tahun Lulus SMP')->default('2025')
                    ]),
                ]),
                Card::make()->schema([
                    Fieldset::make('Data Pribadi | Sesuai Kartu Keluarga')
                        ->schema([
                            TextInput::make('nik')->label('NIK')->numeric()->minLength('9')->required(),
                            TextInput::make('nisn')->label('NISN')->numeric()->minLength('9')->required(),
                            TextInput::make('nama_lengkap')->label('Nama Lengkap')->required(),
                            Radio::make('jk')->options([
                                'L' => 'Laki - Laki',
                                'P' => 'Perempuan'
                            ])->label('Jenis Kelamin'),
                            TextInput::make('tempat_lahir')->label('Tempat Lahir')->required(),
                            DatePicker::make('tgl_lahir')->label('Tanggal Lahir')->default('2008-07-01')->timezone('Asia/Jakarta'),
                            Select::make('agama')->label('Agama')->options([
                                'Islam' => 'Islam',
                                'Kristen' => 'Kristen',
                                'Katholik' => 'Katholik',
                                'Hindu' => 'Hindu',
                                'Buddha' => 'Buddha',
                                'Khonghucu' => 'Khonghucu',
                            ])->searchable()->default('Islam'),
                            TextInput::make('anak_ke')->label('Anak ke')->numeric()->maxLength(2)->required(),
                            TextInput::make('provinsi')->label('Provinsi')->default('Jawa Timur'),
                            TextInput::make('kab_kota')->label('Kabupaten/Kota')->default('Kabupaten Madiun'),
                            TextInput::make('kecamatan')->label('Kecamatan')->default('Kare'),
                            TextInput::make('alamat_lengkap')->label('Alamat Lengkap (Ds, Rt, Rw)')->required(),
                            Select::make('tinggal_bersama')->label('Tinggal Bersama')->options([
                                'Bersama Orang Tua' => 'Bersama Orang Tua',
                                'Wali' => 'Wali',
                                'Kost' => 'Kost',
                                'Asrama' => 'Asrama',
                                'Panti Asuhan' => 'Panti Asuhan',
                                'Pesantren' => 'Pesantren',
                                'Lainya' => 'Lainya',
                            ])->default('Bersama Orang Tua'),
                            Select::make('moda_transpotasi')->label('Moda Transpotasi')->options([
                                'Jalan Kaki' => 'Jalan Kaki',
                                'Angkutan Umum' => 'Angkutan Umum',
                                'Antar Jemput' => 'Antar Jemput',
                                'Kereta Api' => 'Kereta Api',
                                'Ojek' => 'Ojek',
                                'Sepeda' => 'Sepeda',
                                'Sepeda Motor' => 'Sepeda Motor',
                                'Mobil Pribadi' => 'Mobil Pribadi',
                                'Lainya' => 'Lainya',
                            ])->default('Sepeda Motor'),
                        ]),
                ])->columns(2),
                Card::make()->schema([
                    Fieldset::make('Data Periodik')->schema([
                        TextInput::make('tb')->label('Tinggi Badan | Cm')->numeric()->maxLength(3)->required(),
                        TextInput::make('bb')->label('Berat Badan | Kg')->numeric()->maxLength(3)->required(),
                        TextInput::make('lk')->label('Lingkar Kepala | Cm')->numeric()->maxLength(3)->required(),
                        TextInput::make('jarak_rumah')->label('Jarak Rumah Ke Sekolah | Km')->numeric()->maxLength(3)->required(),
                        TextInput::make('waktu_tempuh')->label('Waktu tempuh | Menit')->numeric()->maxLength(3)->required(),
                        TextInput::make('jumlah_saudara')->label('Jumlah Saudara')->numeric()->maxLength(1)->default(0),
                        Select::make('jurusan')->label('Jurusan Yang Dipilih')->options([
                            'Teknik Kendaraan Ringan' => 'Teknik Kendaraan Ringan',
                            'Teknik Komputer dan Jaringan' => 'Teknik Komputer dan Jaringan',
                            'Akuntansi' => 'Akuntansi',
                            'Desain Komunikasi Visual' => 'Desain Komunikasi Visual',
                        ])->required(),
                    ]),
                ])->columns(2),
                Card::make()->schema([
                    Fieldset::make('Data Ibu')->schema([
                        TextInput::make('nama_ibu')->label('Nama Lengkap Ibu')->required(),
                        TextInput::make('nik_ibu')->label('NIK Ibu')->required(),
                        TextInput::make('tahun_ibu')->label('Tahun Lahir Ibu'),
                        TextInput::make('pendidikan_ibu')->label('Pendidikan Ibu'),
                        TextInput::make('pekerjaan_ibu')->label('Pekerjaan Ibu'),
                        TextInput::make('penghasilan_ibu')->label('Penghasilan Ibu'),
                    ]),
                ])->columns(2),
                Card::make()->schema([
                    Fieldset::make('Data Ayah')->schema([
                        TextInput::make('nama_ayah')->label('Nama Lengkap Ayah')->required(),
                        TextInput::make('nik_ayah')->label('NIK Ayah')->required(),
                        TextInput::make('tahun_ayah')->label('Tahun Lahir Ayah'),
                        TextInput::make('pendidikan_ayah')->label('Pendidikan Ayah'),
                        TextInput::make('pekerjaan_ayah')->label('Pekerjaan Ayah'),
                        TextInput::make('penghasilan_ayah')->label('Penghasilan Ayah'),
                    ]),
                ]),
                Card::make()->schema([
                    Fieldset::make('Keperluan PIP')->schema([
                        TextInput::make('nomor_kartu')->label('Nomor Kartu KIP'),
                        TextInput::make('nama_kartu')->label('Nama di Kartu KIP'),
                        Radio::make('kip')->options([
                            'true' => 'Memiliki KIP',
                            'false' => 'Tidak Memiliki KIP',
                        ])->inline()->label(''),
                    ]),

                ]),
                Card::make()->schema([
                    Fieldset::make('File Pendukung')->schema([
                        FileUpload::make('url_kip')->label('Softcopy KIP'),
                        FileUpload::make('url_kk')->label('Softcopy Kartu Keluarga'),
                        Hidden::make('operator')->default(Auth::user()->name)
                    ]),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nisn')->searchable()->sortable()->label('NISN'),
                TextColumn::make('nama_lengkap')->searchable()->sortable()->label('Nama Lengkap'),
                TextColumn::make('jurusan')->searchable()->sortable()->label('Jurusan'),
                TextColumn::make('asal_sekolah')->searchable()->sortable()->label('Asal Sekolah')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNonspmbs::route('/'),
            'create' => Pages\CreateNonspmb::route('/create'),
            'edit' => Pages\EditNonspmb::route('/{record}/edit'),
        ];
    }
}
