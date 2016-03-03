class CreateOutlets < ActiveRecord::Migration
  def change
    create_table :outlets do |t|
      t.string :name, :null => false
      t.string :description
      t.integer :subs, :null => false
      t.integer :dma_id, :null => false
      t.integer :user_id, :null => false

      t.timestamps
    end
  end
end
