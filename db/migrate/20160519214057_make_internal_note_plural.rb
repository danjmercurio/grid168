class MakeInternalNotePlural < ActiveRecord::Migration
  def change
    remove_column :offers, :internalNote
    add_column :offers, :internalNotes, :text
  end
end
