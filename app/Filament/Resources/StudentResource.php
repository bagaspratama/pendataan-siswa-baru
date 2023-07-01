<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Models\Student;
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
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-database';
    protected static ?string $navigationLabel = 'Data PD';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    Fieldset::make('Data Pribadi | Sesuai Kartu Keluarga')
                        ->schema([
                            TextInput::make('nik')->label('NIK')->numeric()->minLength('9'),
                            TextInput::make('nisn')->label('NISN')->numeric()->minLength('9'),
                            TextInput::make('nama_lengkap')->label('Nama Lengkap'),
                            Radio::make('jk')->options([
                                'L' => 'Laki - Laki',
                                'P' => 'Perempuan'
                            ])->label('Jenis Kelamin'),
                            TextInput::make('tempat_lahir')->label('Tempat Lahir'),
                            DatePicker::make('tgl_lahir')->label('Tanggal Lahir')->default('2008-07-01')->timezone('Asia/Jakarta'),
                            Select::make('agama')->label('Agama')->options([
                                'Islam' => 'Islam',
                                'Kristen' => 'Kristen',
                                'Katholik' => 'Katholik',
                                'Hindu' => 'Hindu',
                                'Buddha' => 'Buddha',
                                'Khonghucu' => 'Khonghucu',
                            ])->searchable()->default('Islam'),
                            TextInput::make('anak_ke')->label('Anak ke')->numeric()->maxLength(2),
                            TextInput::make('provinsi')->label('Provinsi')->default('Jawa Timur'),
                            TextInput::make('kab_kota')->label('Kabupaten/Kota')->default('Kabupaten Madiun'),
                            TextInput::make('kecamatan')->label('Kecamatan')->default('Kare'),
                            TextInput::make('alamat_lengkap')->label('Alamat Lengkap (Ds, Rt, Rw)'),
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
                        TextInput::make('tb')->label('Tinggi Badan | Cm')->numeric()->maxLength(3),
                        TextInput::make('bb')->label('Berat Badan | Cm')->numeric()->maxLength(3),
                        TextInput::make('lk')->label('Lingkar Kepala | Cm')->numeric()->maxLength(3),
                        TextInput::make('jarak_rumah')->label('Jarak Rumah Ke Sekolah | Km')->numeric()->maxLength(3),
                        TextInput::make('waktu_tempuh')->label('Waktu tempuh | Menit')->numeric()->maxLength(3),
                        TextInput::make('jumlah_saudara')->label('Jumlah Saudara')->numeric()->maxLength(1)->default(1),
                        Select::make('jurusan')->label('Jurusan Yang Dipilih')->options([
                            'Teknik Kendaraan Ringan' => 'Teknik Kendaraan Ringan',
                            'Teknik Komputer dan Jaringan' => 'Teknik Komputer dan Jaringan',
                            'Akuntansi' => 'Akuntansi',
                            'Desain Komunikasi Visual' => 'Desain Komunikasi Visual',
                        ]),
                    ]),
                ])->columns(2),
                Card::make()->schema([
                    Fieldset::make('Data Ibu')->schema([
                        TextInput::make('nama_ibu')->label('Nama Lengkap Ibu'),
                        TextInput::make('nik_ibu')->label('NIK Ibu'),
                        TextInput::make('tahun_ibu')->label('Tahun Lahir Ibu'),
                        TextInput::make('pendidikan_ibu')->label('Pendidikan Ibu'),
                        TextInput::make('pekerjaan_ibu')->label('Pekerjaan Ibu'),
                        TextInput::make('penghasilan_ibu')->label('Penghasilan Ibu'),
                    ]),
                ])->columns(2),
                Card::make()->schema([
                    Fieldset::make('Data Ayah')->schema([
                        TextInput::make('nama_ayah')->label('Nama Lengkap Ayah'),
                        TextInput::make('nik_ayah')->label('NIK Ayah'),
                        TextInput::make('tahun_ayah')->label('Tahun Lahir Ayah'),
                        TextInput::make('pendidikan_ayah')->label('Pendidikan Ayah'),
                        TextInput::make('pekerjaan_ayah')->label('Pekerjaan Ayah'),
                        TextInput::make('penghasilan_ayah')->label('Penghasilan Ayah'),
                    ]),
                ]),
                Card::make()->schema([
                    Fieldset::make('Data Pendukung')->schema([
                        TextInput::make('asal_sekolah')->label('Asal Sekolah')->default('SMPN '),
                        TextInput::make('no_wa_wali')->label('No Whatsapp Wali | Format 62'),
                        Radio::make('kps_pkh')->options([
                            'true' => 'Memiliki KPS PKH',
                            'false' => 'Tidak Memiliki KPS PKH',
                        ])->inline()->label(''),
                        Radio::make('kip')->options([
                            'true' => 'Memiliki KIP',
                            'false' => 'Tidak Memiliki KIP',
                        ])->inline()->label(''),

                    ]),
                ]),
                Card::make()->schema([
                    Fieldset::make('File Pendukung')->schema([
                        FileUpload::make('url_pkh')->label('Softcopy KPS'),
                        FileUpload::make('url_kip')->label('Softcopy KIP'),
                        FileUpload::make('url_kk')->label('Softcopy Kartu Keluarga'),
                        FileUpload::make('url_ijazah')->label('Softcopy Ijazah/SKL'),
                        Hidden::make('operator')->default(Auth::user()->name)
                    ]),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nisn'),
                TextColumn::make('nama_lengkap'),
                TextColumn::make('jurusan'),
                ImageColumn::make('asal_sekolah')
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
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}
