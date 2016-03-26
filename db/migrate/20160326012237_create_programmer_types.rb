class CreateProgrammerTypes < ActiveRecord::Migration
  def change
    create_table :programmer_types do |t|
      t.string :name

      t.timestamps null: false
    end
  end
end
