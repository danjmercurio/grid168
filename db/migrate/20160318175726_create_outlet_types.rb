class CreateOutletTypes < ActiveRecord::Migration
  def change
    create_table :outlet_types do |t|
      t.string :name

      t.timestamps null: false
    end
  end
end
